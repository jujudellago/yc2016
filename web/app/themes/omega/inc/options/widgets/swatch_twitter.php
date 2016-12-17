<?php
/**
 * Oxygenna.com
 *
 * $Template:: *(TEMPLATE_NAME)*
 * $Copyright:: *(COPYRIGHT)*
 * $Licence:: *(LICENCE)*
 */
require_once OXY_TF_DIR . 'inc/OxygennaWidget.php';
/*
 * Based on Evolution Twitter Timeline (http://wordpress.org/extend/plugins/evolution-twitter-timeline/)
 * See: https://twitter.com/settings/widgets and https://dev.twitter.com/docs/embedded-timelines for details on Twitter Timelines
 */

class Swatch_twitter extends OxygennaWidget {
    /**
    * Register widget with WordPress.
    */
    public function __construct() {
        $widget_options = array( 'description' => __( 'Displays you latest tweets', 'omega-admin-td') );
        parent::__construct( 'swatch_twitter-options.php', false, $name = THEME_NAME . ' - ' . __('Twitter Feed', 'omega-admin-td'), $widget_options );
    }

    function widget( $args, $instance ) {
        
        if ( isset( $instance['account'] ) ) {
            $account = trim( urlencode( $instance['account'] ) );
        }
        if ( empty( $account ) ) {
            if ( current_user_can('edit_theme_options') ) {
                echo $args['before_widget'];
                echo '<p>' . sprintf( __( 'Please configure your Twitter username for the <a href="%s">Twitter Widget</a>.', 'omega-td' ), admin_url( 'widgets.php' ) ) . '</p>';
                echo $args['after_widget'];
            }

            return;
        }

        $show = absint( $instance['show'] );  // # of Updates to show

        if ( $show > 200 ) // Twitter paginates at 200 max tweets. update() should not have accepted greater than 20
            $show = 200;

        $hidereplies        = $this->get_option( 'hidereplies', $instance, 'on');
        $hidepublicized     = $this->get_option( 'hidepublicized', $instance, 'on');
        $include_retweets   = $this->get_option( 'include_retweets', $instance, 'on');
        $follow_button      = $this->get_option( 'follow_button', $instance, 'on');

        $consumer_key        = $this->get_option( 'consumer_key', $instance, 'false');
        $consumer_secret     = $this->get_option( 'consumer_secret', $instance, 'false');
        $access_token        = $this->get_option( 'access_token', $instance, 'false');
        $access_token_secret = $this->get_option( 'access_token_secret', $instance, 'false');
        $title               = $this->get_option( 'title', $instance, 'Twitter feed');


        $tweets = $this->fetch_twitter_user_stream(  $consumer_key, $consumer_secret, $access_token, $access_token_secret, $account, $hidereplies, $show, $include_retweets );

        if ( ! is_wp_error( $tweets ) && is_array( $tweets ) && isset( $tweets[0]->user->id ) ) {
            set_transient( 'widget-twitter-' . $this->number, $tweets, 500 );

            $before_tweet     = isset( $instance['beforetweet'] ) ? stripslashes( wp_filter_post_kses( $instance['beforetweet'] ) ) : '';
            $before_timesince = ( isset( $instance['beforetimesince'] ) && ! empty( $instance['beforetimesince'] ) ) ? esc_html( $instance['beforetimesince'] ) : ' ';

            $this->display_tweets( $show, $title, $tweets, $hidepublicized, $before_tweet, $before_timesince, $account );
            if ( $follow_button == 'on' )
                $this->display_follow_button( $account );
                ?></div><?php
            add_action( 'wp_footer', array( $this, 'twitter_widget_script' ) );
        } else {
            echo '<p>Could not fetch Lists</p>';
        }

        //echo $args['after_widget'];
        do_action( 'jetpack_stats_extra', 'widgets', 'twitter' );
    }

    function display_tweets( $show, $title, $tweets, $hidepublicized, $before_tweet, $before_timesince, $account ) {
        $tweets_out = 0; ?>
        <div class="sidebar-widget  widget_oxy_twitter">
            <h3 class="sidebar-header"><?php
                echo $title; ?>
            </h3>
            <ul><?php

        foreach( (array) $tweets as $key => $value ) {
            if ( $tweets_out >= $show )
                break;
            $text = $value->text;

            if ( empty( $text ) )
                continue;

            if( $hidepublicized == 'on' && false !== strstr( $value->source, 'http://publicize.wp.com/' ) )
                continue;

            $text = esc_html( $text ); // escape here so that Twitter handles in Tweets don't get mangled
            $value= $this->expand_tco_links( $value );
            $text = make_clickable( $text );

            /*
             * Create links from plain text based on Twitter patterns
             * @link http://github.com/mzsanford/twitter-text-rb/blob/master/lib/regex.rb Official Twitter regex
             */
            $text = preg_replace_callback( '/(^|[^0-9A-Z&\/]+)(#|\xef\xbc\x83)([0-9A-Z_]*[A-Z_]+[a-z0-9_\xc0-\xd6\xd8-\xf6\xf8\xff]*)/iu',  array( $this, '_jetpack_widget_twitter_hashtag' ), $text );
            $text = preg_replace_callback( '/([^a-zA-Z0-9_]|^)([@\xef\xbc\xa0]+)([a-zA-Z0-9_]{1,20})(\/[a-zA-Z][a-zA-Z0-9\x80-\xff-]{0,79})?/u', array( $this, '_jetpack_widget_twitter_username' ), $text );

            if ( isset( $value->id_str ) )
                $tweet_id = urlencode( $value->id_str );
            else
                $tweet_id = urlencode( $value->id );

            ?>

            <li>
                <?php echo esc_attr( $before_tweet ) . $text . esc_attr( $before_timesince ) ?>
                <small class="block text-italic">
                    <?php echo esc_html( str_replace( ' ', '&nbsp;', $this->time_since( strtotime( $value->created_at ) ) ) ); ?>&nbsp;ago
                </small>
            </li>

            <?php

            unset( $tweet_it );
            $tweets_out++;
        }

        ?></ul><?php
    }

    function display_follow_button( $account ) {
        global $themecolors;

        $follow_colors        = isset( $themecolors['link'] ) ? " data-link-color='#{$themecolors['link']}'" : '';
        $follow_colors       .= isset( $themecolors['text'] ) ? " data-text-color='#{$themecolors['text']}'" : '';
        $follow_button_attrs  = " class='twitter-follow-button' data-show-count='false'{$follow_colors}";

        ?><a href="http://twitter.com/<?php echo esc_attr( $account ); ?>" <?php echo $follow_button_attrs; ?>>Follow @<?php echo esc_attr( $account ); ?></a><?php
    }

    function expand_tco_links( $tweet ) {
        if ( ! empty( $tweet->entities->urls ) && is_array( $tweet->entities->urls ) ) {
            foreach ( $tweet->entities->urls as $entity_url ) {
                if ( ! empty( $entity_url->expanded_url ) ) {
                    $tweet->text = str_replace(
                        $entity_url->url,
                        '<a href="' . esc_url( $entity_url->expanded_url ) . '"> ' . esc_html( $entity_url->display_url ) . '</a>',
                        $tweet->text
                    );
                }
            }
        }

        return $tweet;
    }

    function fetch_twitter_user_stream( $consumer_key, $consumer_secret, $access_token, $access_token_secret, $account, $hidereplies, $show, $include_retweets ) {
        $tweets    = get_transient( 'widget-twitter-' . $this->number );
        $the_error = get_transient( 'widget-twitter-error-' . $this->number );

        if ( ! $tweets ) {
            require_once 'widget-options/twitteroauth/twitteroauth.php';
            $connection = new TwitterOAuth( $consumer_key, $consumer_secret, $access_token, $access_token_secret );

            $params = array(
                'screen_name'      => $account, // Twitter account name
                'trim_user'        => true,     // only basic user data (slims the result)
                'include_entities' => true
            );

            // If combined with $count, $exclude_replies only filters that number of tweets (not all tweets up to the requested count).
            if ( $hidereplies == 'on' )
                $params['exclude_replies'] = true;
            else
                $params['count'] = $show;

            if ( $include_retweets == 'on')
                $params['include_rts'] = true;

            $response = $connection->get( 'statuses/user_timeline', $params );

            $tweets = array();
            if( is_wp_error( $response ) ) {
               $tweets = array();
            } else {
                if ( isset( $response->errors ) ) {
                    $tweets = array();
                } else if ( isset( $response[0]->user->id ) ) {
                    $tweets = $response;
                }
            }


        }
        return $tweets;
    }


    function time_since( $original, $do_more = 0 ) {
        // array of time period chunks
        $chunks = array(
            array(60 * 60 * 24 * 365 , 'year'),
            array(60 * 60 * 24 * 30 , 'month'),
            array(60 * 60 * 24 * 7, 'week'),
            array(60 * 60 * 24 , 'day'),
            array(60 * 60 , 'hour'),
            array(60 , 'minute'),
        );

        $today = time();
        $since = $today - $original;

        for ($i = 0, $j = count($chunks); $i < $j; $i++) {
            $seconds = $chunks[$i][0];
            $name = $chunks[$i][1];

            if (($count = floor($since / $seconds)) != 0)
                break;
        }

        $print = ($count == 1) ? '1 '.$name : "$count {$name}s";

        if ($i + 1 < $j) {
            $seconds2 = $chunks[$i + 1][0];
            $name2 = $chunks[$i + 1][1];

            // add second item if it's greater than 0
            if ( (($count2 = floor(($since - ($seconds * $count)) / $seconds2)) != 0) && $do_more )
                $print .= ($count2 == 1) ? ', 1 '.$name2 : ", $count2 {$name2}s";
        }
        return $print;
    }

    /**
     * Link a Twitter user mentioned in the tweet text to the user's page on Twitter.
     *
     * @param array $matches regex match
     * @return string Tweet text with inserted @user link
     */
    function _jetpack_widget_twitter_username( array $matches ) { // $matches has already been through wp_specialchars
        return "$matches[1]@<a href='" . esc_url( 'http://twitter.com/' . urlencode( $matches[3] ) ) . "'>$matches[3]</a>";
    }

    /**
     * Link a Twitter hashtag with a search results page on Twitter.com
     *
     * @param array $matches regex match
     * @return string Tweet text with inserted #hashtag link
     */
    function _jetpack_widget_twitter_hashtag( array $matches ) { // $matches has already been through wp_specialchars
        return "$matches[1]<a href='" . esc_url( 'http://twitter.com/search?q=%23' . urlencode( $matches[3] ) ) . "'>#$matches[3]</a>";
    }

    function twitter_widget_script() {
        if ( ! wp_script_is( 'twitter-widgets', 'registered' ) ) {
            if ( is_ssl() )
                $twitter_widget_js = 'https://platform.twitter.com/widgets.js';
            else
                $twitter_widget_js = 'http://platform.twitter.com/widgets.js';
            wp_register_script( 'twitter-widgets', $twitter_widget_js,  array(), '20111117', true );
            wp_print_scripts( 'twitter-widgets' );
        }
    }
}
