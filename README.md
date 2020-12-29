# STARTER

Starter WooCommerce theme, how it looks/works by default see here https://starter.rsdev.in/.  
Open source, free to use - [MIT](https://choosealicense.com/licenses/mit/) license.


# TWO IMPORTAN THINGS
1. THE THEME IS UNDER ACTIVE DEVELOPMENT (RELEASED TWO ALPHA VERSIONS) BUT IT'S PRETTY CLOSE TO **FIRST STABLE RELEASE** - FIRST RELEASE IS PLANNING **BEFORE NEW YEAR**!
2. DUE IT'S ALPHA VERSION _SOME DOCIMENTATION UNACTUAL_, IT **WILL BE FIXED BEFORE FIRST STABLE RELEASE**.  
#### STAY WITH US :-)
<br><br>



# Table of content

- [About](#-about)
- [Installation & Usage](#-installation--usage)
  - [Requirements](#-requirements)
  - [Setup](#-setup)
  - [Build commands](#-build-commands)
  - [Highly recommended/integrated to theme plugins](#-highly-recommendedintegrated-to-theme-plugins)
- [DOCUMENTATION](https://github.com/chyvak1831/starter/wiki)
- [Contributing](#-contributing)
- [License](#-license)
***
<br>



# ❔ About
This theme **keeps your time**: it provides main ecommerce pages ready to easy and fast customize (home, catalog, single page) and a few great **features which usually used or must have**.

#### ✔️ Pros
✓ easy to customize layout  
✓ load speed ready  
✓ retina ready  
✓ extended by a few cool features  

#### ‼️ Cons
frontend plugins (which affects to home, catalog, single) are require **code integration** via shortcodes or functions usually - due **theme does not used hooks** for these pages (i.e. just "install plugin and activate" - does not works)
***
<br>



# 🔧 Installation & Usage

### ✅ Requirements
Probably Starter will works with other plugin versions - but with versions below it's tested.
* [WordPress](https://wordpress.org/) >= 5.5
* [ACF](https://wordpress.org/plugins/advanced-custom-fields/) >= 5.9.0
  <details><summary>Show details</summary>
  You can to install: <strong>"ACF Pro"</strong> - <em>all features available</em> or <strong>Basic ACF</strong> - <em>is not available Home Page features</em> and you'll not see <em>comment images</em> in admin due gallery and repeater features are not available in free version.<br>
  After installation go to ACF and sync fields.
  <img src="https://github.com/chyvak1831/starter_img/blob/master/acf_sync.jpg?raw=true" alt="ACF sync settings"></details>
* [Classic Editor](https://wordpress.org/plugins/classic-editor/) >= 1.6
* [EWWW Image Optimizer](https://wordpress.org/plugins/ewww-image-optimizer/) >= 5.7.0
  <details><summary>Show details</summary>
  After installation go to EWWW setting and enable 'WebP Conversion' & 'Force WebP'.
  <img src="https://github.com/chyvak1831/starter_img/blob/master/ewww.jpg?raw=true" alt="EWWW settings"></details>
*  [TinyMCE Advanced](https://wordpress.org/plugins/tinymce-advanced/) >= 5.5.0
    <details><summary>Show details</summary>
    After installation copy settings
    
      ```json
      {
        "settings": {
          "toolbar_1":"bold,italic,underline,forecolor,blockquote,bullist,numlist,alignleft,aligncenter,alignright,alignjustify,link,unlink,undo,redo,wp_adv",
          "toolbar_2":"formatselect,fontselect,fontsizeselect,styleselect,pastetext,removeformat,fullscreen",
          "toolbar_3":"",
          "toolbar_4":"",
          "options":"advlist,menubar_block,merge_toolbars",
          "plugins":"advlist",
          "toolbar_block":"core\/image,core\/image",
          "toolbar_block_side":"tadv\/sup,tadv\/sub,core\/strikethrough,core\/code,tadv\/mark,tadv\/removeformat",
          "panels_block":"tadv\/color-panel,tadv\/background-color-panel",
          "toolbar_classic_block":"formatselect,bold,italic,blockquote,bullist,numlist,alignleft,aligncenter,alignright,link,forecolor,backcolor,table,wp_help"
        },
        "admin_settings": {
          "options":"hybrid_mode,classic_paragraph_block,table_resize_bars,table_grid,table_tab_navigation,table_advtab",
          "disabled_editors":""
        }
      }
    ```
    Go to settings 
    <img src="https://github.com/chyvak1831/starter_img/blob/master/wysiwyg_01.jpg?raw=true" alt="TinyMCE settings 1">
    <img src="https://github.com/chyvak1831/starter_img/blob/master/wysiwyg_02.jpg?raw=true" alt="TinyMCE settings 2">
    And paste here
    <img src="https://github.com/chyvak1831/starter_img/blob/master/wysiwyg_03.jpg?raw=true" alt="TinyMCE settings 3">
    </details>
* [WooCommerce](https://wordpress.org/plugins/woocommerce/) >= 4.4.1
* [W3 Total Cache](https://wordpress.org/plugins/w3-total-cache/) >= 0.14.4
  <details><summary>Show details</summary>
  W3TC used for optimize page cache and js only.
  <img src="https://github.com/chyvak1831/starter_img/blob/master/w3tc_01.jpg?raw=true" alt="W3TC settings 1">
  <img src="https://github.com/chyvak1831/starter_img/blob/master/w3tc_02.jpg?raw=true" alt="W3TC settings 2"></details>
* [Node.js](https://nodejs.org/) = 14.x
    <details><summary>Version's details</summary>
      Tested with versions <a href="https://nodejs.org/download/release/v14.8.0/">v14.8.0</a> and <a href="https://nodejs.org/download/release/v14.15.3/">v14.15.3</a>, but it should works with any 14.x version.<br>
      Due short life-cycle of node <a href="https://nodejs.org/en/about/releases/">v15</a> Starter <strong>will never officially compatible with node v15</strong>.
    </details>
* gulp = 2.3.0 (how to install - see next step Setup)

### 🔧 Setup
1. Install [Requirements](#-requirements)
2. Install gulp globally (if it's not installed yet) - do it once
    ```bash
    npm i --global gulp-cli
    ```
3. Go to theme folder and run cmd/terminal and install packages
    ```bash
    npm i
    ```

### 🚀 Build commands

**Default task** (for development):
  ```bash
  gulp
  ```  
Open site with port 4000 to get [browserSync](https://browsersync.io/docs/gulp) reloads.

**Production task**:
  ```bash
  gulp production
  ```


### 👍 Highly recommended/integrated to theme plugins
* [Advanced Woo Search](https://wordpress.org/plugins/advanced-woo-search/) >= 2.09 (see [Widgets (search, minicart, wishlist) in menu](https://github.com/chyvak1831/starter/wiki/Menus))
* [WP Widget in Navigation](https://wordpress.org/plugins/wp-widget-in-navigation/) >= 2.0.1 (see [Widgets (search, minicart, wishlist) in menu](https://github.com/chyvak1831/starter/wiki/Menus))
* [TI WooCommerce Wishlist](https://wordpress.org/plugins/ti-woocommerce-wishlist/) >= 1.21.2 (see [Widgets (search, minicart, wishlist) in menu](https://github.com/chyvak1831/starter/wiki/Menus))
  <details><summary>Show details</summary>
    After installation go to TI Wishlist and setup minimum recommnded settings. You can to play with other settings.
  <img src="https://github.com/chyvak1831/starter_img/blob/master/ti_wishlist_01.jpg?raw=true" alt="TI Wishlist settings 1">
  <img src="https://github.com/chyvak1831/starter_img/blob/master/ti_wishlist_02.jpg?raw=true" alt="TI Wishlist settings 2">
  <img src="https://github.com/chyvak1831/starter_img/blob/master/ti_wishlist_03.jpg?raw=true" alt="TI Wishlist settings 3">
  <img src="https://github.com/chyvak1831/starter_img/blob/master/ti_wishlist_04.jpg?raw=true" alt="TI Wishlist settings 4"></details>
* [Yoast SEO](https://wordpress.org/plugins/wordpress-seo/) >= 14.8.1
  <details><summary>Show details</summary>
  After installation go to SEO->Search Appearance-> tab Breadcrumbs and enable 'Enable Breadcrumbs'
  <img src="https://github.com/chyvak1831/starter_img/blob/master/breadcrumb.jpg?raw=true" alt="Breadcrumbs Yoast SEO"></details>
***
<br>



# 🤝 Contributing
Please open an issue first to discuss what you would like to change.
***
<br>



# 📘 License
[MIT](https://choosealicense.com/licenses/mit/)
