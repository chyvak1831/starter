# STARTER

Starter WooCommerce theme, how it looks/works by default see here https://starter-demo.dakha.info/shop.  
Open source, free to use - MIT license.



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
This theme **keeps your time**: it provides main ecommerce pages ready for easy and fast customize (home, catalog, single page) and a few great **features which usually used or must have**.

#### ✔️ 6 main reasons to use Starter
1. **easy to customize** [layout](https://github.com/chyvak1831/starter/wiki/Templates)  
2. it developed in according with [WPCS](https://github.com/WordPress/WordPress-Coding-Standards) so existing custom **code is secure**  
3. **load speed ready**: load time for dekstop is **under 1 second**, for mobile is **under 3 seconds**; the weight of homepage and catalog is only **about 300kb**, the weight of single product page is only **about 200kb**.
    <details><summary>Details</summary>
   <img src="https://raw.githubusercontent.com/chyvak1831/starter_img/master/archive/v1.2.0/screenshots/weight_shop.jpg" alt="Weight shop page">
   <img src="https://raw.githubusercontent.com/chyvak1831/starter_img/master/archive/v1.2.0/screenshots/weight_single.jpg" alt="Weight single product page">
   <strong>Please note</strong>: load time and weight of pages described above - it's Starter as is, without any third-party resources. When you'll add google analitycs, gtm etc - it will down and it's ok.</details>  
4. **lighthouse**: seo, best practice, accessability is **100**! Performance (aka google pagespeed): it's **96-100** for homepage, shop, category, product page, support and simple pages.
    <details><summary>Details</summary>
   <img src="https://raw.githubusercontent.com/chyvak1831/starter_img/master/archive/v1.2.0/screenshots/lighthouse.jpg" alt="Lighthouse">
   <strong>Please note #1</strong>: lighthouse metrics described above - it's Starter as is, without any third-party resources. When you'll add google analitycs, gtm etc - it will down and it's ok.  
   <strong>Please note #2</strong>: Performance metric is vary from time to time +-5 points and it's ok.</details> 
5. [retina ready](https://github.com/chyvak1831/starter/wiki/Images)  
6. extended by a few **cool features** (plugin-less): [ajax filter/sort/pagination](https://github.com/chyvak1831/starter/wiki/Filters), [color filters, filter display types](https://github.com/chyvak1831/starter/wiki/Filters), [google fonts](https://github.com/chyvak1831/starter/wiki/Fonts), [comments](https://github.com/chyvak1831/starter/wiki/Comments), [menus](https://github.com/chyvak1831/starter/wiki/Menus).  

#### ‼️ 1 reason not to use
1. frontend plugins (which affects to home, catalog, single) are require **code integration** via shortcodes or functions usually - due **theme does not used hooks** for these pages (i.e. just "install plugin and activate" - does not works)
***
<br>



# 🔧 Installation & Usage

### ✅ Requirements
Probably Starter will works with other plugin versions - but with versions below it's tested.
* [WordPress](https://wordpress.org/) >= 5.9
* [ACF](https://wordpress.org/plugins/advanced-custom-fields/) >= 5.11.4
  <details><summary>Show details</summary>
  You can to install: <strong>"ACF Pro"</strong> - <em>all features available</em> or <strong>Basic ACF</strong> - <em>is not available Home Page features</em> and you'll not see <em>comment images</em> in admin due gallery and repeater features are not available in free version.<br>
  After installation go to ACF and sync fields.
  <img src="https://raw.githubusercontent.com/chyvak1831/starter_img/master/archive/v1.2.0/screenshots/acf_sync.jpg" alt="ACF sync settings"></details>
*  [Advanced Editor Tools (previously TinyMCE Advanced)](https://wordpress.org/plugins/tinymce-advanced/) >= 5.6.0
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
    <img src="https://raw.githubusercontent.com/chyvak1831/starter_img/master/archive/v1.2.0/screenshots/wysiwyg/wysiwyg_01.jpg" alt="TinyMCE settings 1">
    <img src="https://raw.githubusercontent.com/chyvak1831/starter_img/master/archive/v1.2.0/screenshots/wysiwyg/wysiwyg_02.jpg" alt="TinyMCE settings 2">
    And paste here
    <img src="https://raw.githubusercontent.com/chyvak1831/starter_img/master/archive/v1.2.0/screenshots/wysiwyg/wysiwyg_03.jpg" alt="TinyMCE settings 3">
    </details>
* [Classic Editor](https://wordpress.org/plugins/classic-editor/) >= 1.6.2
* [EWWW Image Optimizer](https://wordpress.org/plugins/ewww-image-optimizer/) >= 6.4.1
  <details><summary>Show details</summary>
  After installation go to EWWW setting and enable 'WebP Conversion' & 'Force WebP'.
  <img src="https://raw.githubusercontent.com/chyvak1831/starter_img/master/archive/v1.2.0/screenshots/ewww.jpg" alt="EWWW settings"></details>
* [W3 Total Cache](https://wordpress.org/plugins/w3-total-cache/) >= 2.2.1
  <details><summary>Show details</summary>
  W3TC used for optimize page cache and js only.
  <img src="https://raw.githubusercontent.com/chyvak1831/starter_img/master/archive/v1.2.0/screenshots/w3tc_01.jpg" alt="W3TC settings 1">
  <img src="https://raw.githubusercontent.com/chyvak1831/starter_img/master/archive/v1.2.0/screenshots/w3tc_02.jpg" alt="W3TC settings 2"></details>
* [Node.js](https://nodejs.org/) = 17.x.x (**IMPORTANT for Windows: be sure that you're using x86 version, e.g. [v17](https://nodejs.org/download/release/v17.0.0/node-v17.0.0-x86.msi))
* gulp = 4.0.2 (how to install - see next step Setup)

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
4. Setup your local domain in `config.js`: replace `yourdomain` into your local domain - it's required for [browserSync](https://browsersync.io/docs/gulp) and for [Critical CSS](https://github.com/chyvak1831/starter/wiki/CSS)

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
* [WooCommerce](https://wordpress.org/plugins/woocommerce/) >= 6.2.0
* [Advanced Woo Search](https://wordpress.org/plugins/advanced-woo-search/) >= 2.47 (see [Widgets (search, minicart, wishlist) in menu](https://github.com/chyvak1831/starter/wiki/Menus))
* [TI WooCommerce Wishlist](https://wordpress.org/plugins/ti-woocommerce-wishlist/) >= 1.40.1 (see [Widgets (search, minicart, wishlist) in menu](https://github.com/chyvak1831/starter/wiki/Menus))
  <details><summary>Show details</summary>
    After installation go to TI Wishlist and setup minimum recommnded settings. You can to play with other settings.
  <img src="https://raw.githubusercontent.com/chyvak1831/starter_img/master/archive/v1.2.0/screenshots/wishlist/wishlist_01.jpg" alt="TI Wishlist settings 1">
  <img src="https://raw.githubusercontent.com/chyvak1831/starter_img/master/archive/v1.2.0/screenshots/wishlist/wishlist_02.jpg" alt="TI Wishlist settings 2">
  <img src="https://raw.githubusercontent.com/chyvak1831/starter_img/master/archive/v1.2.0/screenshots/wishlist/wishlist_03.jpg" alt="TI Wishlist settings 3">
  <img src="https://raw.githubusercontent.com/chyvak1831/starter_img/master/archive/v1.2.0/screenshots/wishlist/wishlist_04.jpg" alt="TI Wishlist settings 4"></details>
* [Yoast SEO](https://wordpress.org/plugins/wordpress-seo/) >= 18.1
  <details><summary>Show details</summary>
  After installation go to SEO->Search Appearance-> tab Breadcrumbs and enable 'Enable Breadcrumbs'
  <img src="https://raw.githubusercontent.com/chyvak1831/starter_img/master/archive/v1.2.0/screenshots/breadcrumb.jpg" alt="Breadcrumbs Yoast SEO"></details>
* [WP Widget in Navigation](https://wordpress.org/plugins/wp-widget-in-navigation/) >= 3.0.1 (see [Widgets (search, minicart, wishlist) in menu](https://github.com/chyvak1831/starter/wiki/Menus))
***
<br>



# 🤝 Contributing
Please open an issue first to discuss what you would like to change.
***
<br>



# 📘 License
[MIT](https://choosealicense.com/licenses/mit/)
