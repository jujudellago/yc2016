# Theme Build system
                               ,---.
                              /    |
                             /     |
    One Command             /      |
    To Build               /       |
    Them All          ___,'        |
                    <  -'          :
                     `-.__..--'``-,_\_
                        |o/ <o>` :,.)_`>
                        :/ `     ||/)
                        (_.).__,-` |\
                        /( `.``   `| :
                        \'`-.)  `  ; ;
                        | `       /-<
                        |     `  /   `.
        ,-_-..____     /|  `    :__..-'\
       /,'-.__\\  ``-./ :`      ;       \
       `\ `\  `\\  \ :  (   `  /  ,   `. \
         \` \   \\   |  | `   :  :     .\ \
          \ `\_  ))  :  ;     |  |      ): :
         (`-.-'\ ||  |\ \   ` ;  ;       | |
          \-_   `;;._   ( `  /  /_       | |
           `-.-.// ,'`-._\__/_,'         ; |
              \:: :     /     `     ,   /  |
               || |    (        ,' /   /   |
               ||                ,'   /    |

## How to build

    ant build

This will trigger the following ant build process jobs

- html
    * html-build
    * html-build-docs
    * html-build-release
    * html-build-themeforest
- wordpress
    * wordpress-build
    * wordpress-build-docs
        - wordpress-build-shortcode-docs
        - wordpress-build-theme-options-docs
    * wordpress-build-release
        - wordpress-build-child
    * wordpress-build-themeforest

## Final result

You should end up with an artifacts folder containing themeforest ready release files for both HTML and WordPress sites

- **artifacts**
    * **html**
        - **build** *html build*
        - **docs** *documentation build*
        - **release** *release zip contents*
        - **themeforest** *final upload files for themeforest*
        - **build** *HTML zip file*
    * **wordpress**
        - **build** *wp build*
        - **docs** *documentation build*
        - **release** *release zip contents*
        - **themeforest** *final upload files for themeforest*
        - **build.zip** *theme zip file*

## Update wordpress assets folder

  ant update-design

This will do a wordpress build for the assets folder and copy it into the theme root