# STARTER

Starter WooCommerce theme.  
Open source, free to use - [MIT](https://choosealicense.com/licenses/mit/) license.



# Table of content

- [About](#-about)
- [Installation & Usage](#-installation--usage)
  - [Requirements](#-requirements)
  - [Setup](#-setup)
  - [Build commands](#-build-commands)
  - [Highly recommended/integrated to theme plugins](#-highly-recommendedintegrated-to-theme-plugins)
- [Overview (**Important to read**)](#-overview)
  - [Templates](#templates)
  - [Gulp](#gulp)
  - [CSS](#css)
  - [JS](#js)
- [Comments](#-comments)
- [Filters](#-filters)
  - [Display types](#%EF%B8%8F%EF%B8%8F-display-types)
  - [Color filter](#-color-filter)
  - [Frontend filter logic](#-frontend-filter-logic)
  - [Code](#code)
- [Fonts](#-fonts)
- [Images](#-images)
- [Menus](#-menus)
- [Theme Structure](#-theme-structure)
- [Contributing](#-contributing)
- [License](#-license)
***
<br>



# ❔ About
You **don't like digging in woo hooks** to implement client's design? If yes - say 🖕 to hooks and develop woo shop using custom templates!  
This theme **keeps your time**: it provides main ecommerce pages ready to easy and fast customize (home, catalog, single page) and a few great **features which usually used or must have**.

#### ✔️ Pros
✓ easy to customize layout  
✓ load speed ready  
✓ retina ready  
✓ extended by a few cool features  

#### ‼️ Cons
frontend plugins are require **code integration** (shortcodes or functions usually) - due **theme does not used hooks** (i.e. just "install plugin and activate" - does not works)
***
<br>



# 🔧 Installation & Usage

### ✅ Requirements
Probably Starter will works with other plugin versions - but with versions below it's tested.
* [WordPress](https://wordpress.org/) >= 5.5
* [ACF](https://wordpress.org/plugins/advanced-custom-fields/) >= 5.9.0
  <details><summary>Show details</summary>
  You can to install: "ACF Pro" - all features available or Basic ACF - is not available Home Page features and you'll not see comment images in admin due gallery and repeater features are not available in free version.<br>
  After installation go to ACF and sync fields.
  <img src="https://github.com/chyvak1831/starter_img/blob/master/acf_sync.jpg?raw=true" alt="ACF sync settings"></details>
* [Classic Editor](https://wordpress.org/plugins/classic-editor/) >= 1.6
* [EWWW Image Optimizer](https://wordpress.org/plugins/ewww-image-optimizer/) >= 5.7.0
  <details><summary>Show details</summary>
  After installation go to EWWW setting and enable 'WebP Conversion' & 'Force WebP'.
  <img src="https://github.com/chyvak1831/starter_img/blob/master/ewww.jpg?raw=true" alt="EWWW settings"></details>
*  [TinyMCE Advanced](https://wordpress.org/plugins/tinymce-advanced/) >= 5.5.0
    <details><summary>Show details</summary>
    After installation go to settings
    <img src="https://github.com/chyvak1831/starter_img/blob/master/wysiwyg_01.jpg?raw=true" alt="TinyMCE settings 1">
    <img src="https://github.com/chyvak1831/starter_img/blob/master/wysiwyg_02.jpg?raw=true" alt="TinyMCE settings 2">
    <img src="https://github.com/chyvak1831/starter_img/blob/master/wysiwyg_03.jpg?raw=true" alt="TinyMCE settings 3">
    and import settings
    
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
    </details>
* [WooCommerce](https://wordpress.org/plugins/woocommerce/) >= 4.4.1
* [W3 Total Cache](https://wordpress.org/plugins/w3-total-cache/) >= 0.14.4
* [Node.js](https://nodejs.org/) >= 14.8.0

### 🔧 Setup
1. Install  [Requirements](#requirements)
2. Install gulp globally (if it's not installed yet) - do it once
    ```bash
    npm i --global gulp-cli
    ```
3. Go to theme folder and run cmd/terminal and install packages
    ```bash
    npm i
    ```

### 🚀 Build commands
Development preparation: open file ```config.js``` and replace each ```yourdomain``` into your local domain; ```URLtosinglepage``` should be replaced into URL to one of your single page (needs for generate critical CSS).  

**Default task** (for development):
  ```bash
  gulp
  ```  
Add port 4000 for to get browserSync reloads.

**Production task**:
  ```bash
  gulp production
  ```


### 👍 Highly recommended/integrated to theme plugins
* [Advanced Woo Search](https://wordpress.org/plugins/advanced-woo-search/) >= 2.09 (example using [here](#user-content-widgets_example))
* [WP Widget in Navigation](https://wordpress.org/plugins/wp-widget-in-navigation/) >= 2.0.1 (example using [here](#user-content-widgets_example))
* [TI WooCommerce Wishlist](https://wordpress.org/plugins/ti-woocommerce-wishlist/) >= 1.21.2 (example using [here](#user-content-widgets_example))
  <details><summary>Minimum recommnded settings</summary>
    After installation go to TI Wishlist and setup custom images, enable 'Remove product from Wishlist on second click', disable 'Show button text' for catalog, single and counter. You can to play with other settings.</details>
* [Yoast SEO](https://wordpress.org/plugins/wordpress-seo/) >= 14.8.1
  <details><summary>Enable breadcrumb</summary>
  After installation go to SEO->Search Appearance-> tab Breadcrumbs and enable 'Enable Breadcrumbs'
  <img src="https://github.com/chyvak1831/starter_img/blob/master/breadcrumb.jpg?raw=true" alt="Breadcrumbs Yoast SEO"></details>
***
<br>



# 🌀 Overview
### Templates
The main difference in development in Starter is **custom templates**: instead of hell with hooks just use **raw data** from woo! For example: instead of getting thumbnails with 💩-markup - just get ids array and use with any your own markup!
```php
$product->get_gallery_image_ids() //get thumbnail ids on single page
```
and use it with any markup
```php
<?php foreach ( $starter_thumbnails as $starter_thumbnail_img ) : ?>
  <picture class="thumbnail js_thumbnail" data-zoom-img="<?php echo esc_attr( wp_get_attachment_image_src( $starter_thumbnail_img, 'w2000' )[0] ); ?>">
    <?php echo do_shortcode( "[img img_src='w200' img_sizes='70px' img_object=\"$starter_thumbnail_img\"]" ); ?>
  </picture>
<?php endforeach; ?>
```
Theme contain custom tempaltes for **home, archive, single**.  
**Account/cart/checkout** are not ovverrided, they are styled using css (and a bit js for to add css classes) because usually these pages very similar and *it's not easy* to get raw data and *to maintain*  (due so much logic present on checkout for example).

### Gulp
Styles and scripts processed by gulp.  
All development dependencies and plugins listed in file ```package.json```.  
File ```gulpfile.js``` contain gulp tasks.  
File ```config.js``` contain configs. 

### CSS
Styles orginized by scss, there are postCSS autoprefixer - so please **forgot about prefixes**.
1. **Plugins** downloads via npm, listed in file ```package.json```.  
Plugins **combines into** one file ```assets\css\plugins.css``` by gulp, all files listed in file ```assets\scss\plugins.scss```.  
In file ```assets\scss\plugins.scss``` you can to comment **bootstrap css modules which is not used** by you.  
2. **Custom styles** ```assets\scss\theme``` combines into one file ```assets\css\styles.css``` by gulp, all files listed in file ```assets\scss\styles.scss```.  
File ```assets\scss\wp_admin.scss``` contain *css which loads to WordPress admin*.
3. **Critical CSS** and **preload**: for to avoid render-blocking CSS each rel='stylesheet' replaced into rel='preload'. As result there is [FOUC](https://en.wikipedia.org/wiki/Flash_of_unstyled_content) - so it's required to have *critical CSS*.  
Critical CSS generates gulp using npm [Critical](https://www.npmjs.com/package/critical), all files listed into ```config.js``` array criticalSrcPages. If you need - feel free to edit this array how you need.

### JS
1. **Plugins** downloads via npm, listed in file ```package.json```.  
Plugins **combines into** one file ```assets\js\plugins.js``` by gulp, all files listed in file ```assets\js\list_plugins.js```. In file ```assets\js\list_plugins.js``` you can to comment **bootstrap js modules which is not used** by you.  
2. **Custom scripts** ```assets\js\modules``` combines into one file ```assets\js\scripts.js``` by gulp, all files listed in file ```assets\js\list_scripts.js```.
***
<br>



# 💬 Comments
Used **default wordpress comment** feature extended by custom cool features: recaptcha, ajax for submit comment and load to front, image field, extended rating.  
### More documentation and examples *coming soon*!
***
<br>



# 🔍 Filters
Starter uses **default woo filter** feature (supported **price** and **attributes** filters) extended by custom cool features.  
Widget area for add filters to archive is **'Archive product'**.  
How to work with default woo filter widgets - there are a lot info in internet, for example official docs https://docs.woocommerce.com/document/woocommerce-widgets/ or see below *'Filter display types GIF example'*.
<br>

### 📄〽️〰️ Display types
Fitlers has two custom selects for setup display type on front.

#### How to use
1. Open widgets
2. Add fitler (or expand existing) and **setup display types** for dekstop and mobile (by default used 'list' type)
<details><summary><strong>Filter display types GIF example</strong></summary>
  <img src="https://github.com/chyvak1831/starter_img/blob/master/filter_display_type.gif?raw=true" alt="Filter: display type">
</details>

#### How it works?
To filter class fork ```inc\woocommerce\filterclass-wc-widget-layered-nav.php``` added ACF ```Filter widget``` for dekstop/mobile display types and added required minimum markup for dropdown and collapse. Filter diplay type settings handled via css ```woo/_filters.scss```.
<br>

### 🔴⚫🔵 Color filter

#### How to use
1. Open any attribute
2. Add color
<details><summary><strong>Color filter GIF example</strong></summary>
  <img src="https://github.com/chyvak1831/starter_img/blob/master/filter_color.gif?raw=true" alt="Color filter">
</details>

#### How it works?
To filter class fork ```inc\woocommerce\filterclass-wc-widget-layered-nav.php``` added ACF ```Color taxonomy``` and required minimum markup. Styled in file ```woo/_filters.scss```.
<br>

### 💭 Frontend filter logic
Default woo uses for filter links: by each click page reloads with new query string in URL.  
Starter **uses fork of default woo filters** ```inc\woocommerce\filterclass-wc-widget-layered-nav.php``` where link logic replaced into checkboxes: by each click filter only getting select status (checkbox checked or unchecked) without page reloading, i.e. **in fact filters are collects via js** ```filters.js```. When user selected filters - he can submit form and page reloads.
<details><summary><strong>Frontend filter logic GIF example</strong></summary>
  <img src="https://github.com/chyvak1831/starter_img/blob/master/filter_demonstration.gif?raw=true" alt="Frontend filter logic">
</details>

In future filters will be added ajax support so all will works without reloads. 

### Code
* ACF: ```Filter widget``` and ```Color taxonomy```
* css: ```woo/_filters.scss```
* js: ```filters.js```
* tpl:
    * ```woocommerce/archive-product.php```:
      * `<!-- get active filters - used when 'No products found' so .js_form_filter form is empty -->` - get active filters
      * `<!-- filters --`> - filters markup
    * ```woocommerce/content-widget-price-filter.php``` - ovverride default woo price filter tpl
* logic:
    * ```inc/woocommerce/filter/filter.php``` - unregister default attr fitler and register fork; customize price filter layout - add data from ACF; Change Price Filter Widget Increment; customize text in Sort select; Register Archive page widget area
    * ```inc/woocommerce/filter/class-wc-widget-layered-nav.php``` - fork of default woo Widget filter
***
<br>



# 🔠 Fonts
By default used 'Open Sans' font family.  

#### How to use
1. Select any **google fonts**
2. Copy-paste **embed code** into ```Appearance->Customize->Site Identity```
3. Add **one** default font-family - used by default for whole site and as default font in wysiwyg editor  
<details><summary><strong>Fonts GIF example</strong></summary>
  <img src="https://github.com/chyvak1831/starter_img/blob/master/fonts.gif?raw=true" alt="Fonts">
</details>

#### Benefits:  
✓ add any google font family so fast & easy  
✓ use any google font family in WYSIWYG. All fonts displays correctly in WYSIWYG.  
✓ use any font-weight! For example 'Open Sans' with font-weight: 100 displays in admin 'Open Sans Light'
<br>

#### Code
Whole code placed into file ```inc\tiny-mce-advanced.php``` comment "Google fonts feature"
***
<br>



# 🌅 Images
* Content images: optimized by EWWW Image Optimizer plugin. Each **image slices by each 200px** (200px, 400px, 600px etc) for deliver **best image sizes** for each device.  
Starter support **webp images** with jpg/png fallback.
* decor graphics: for decor elements uses **svg image spritesheet** ```assets\svg-icons.svg``` via ```starter_get_svg``` (fork of twentyseventeen/inc/icon-functions.php). This svg file loads via pure 'ajax' ```footer.php``` for make it cacheable.
#### Code
Whole code placed into file ```inc\image.php```.
### More documentation and examples *coming soon*!
***
<br>



# ✨ Menus
Wordpress menus extended by ACF so it allows **to generate header** prototype.  
There are 6 menu locations are provided by Starter: 'Header Top Area', 'Header Main Area', 'Header Mobile Top Area', 'Header Mobile Area', 'Footer Area', 'Service Area'.  

### How to use
**I)** Add **simple menu** - that's default wordpress menu.
<details><summary><strong>Simple menu GIF example</strong></summary>
  <img src="https://github.com/chyvak1831/starter_img/blob/master/menu_simple.gif?raw=true" alt="Menu Simple">
</details>

**II)** Add **image and icons** :
 * image: it's possible to use any image format but highly recommended to use svg
 * icons: allowed svg only
<details><summary><strong>Image and icons GIF example</strong></summary>
  <img src="https://github.com/chyvak1831/starter_img/blob/master/menu_img_icon.gif?raw=true" alt="Menu Image Icon">
</details>

**III)** Add **widgets to menus**: so far we used simple links in menus - let's to add **interactive elements**!  
To use widgets in menus install plugin *WP Widget in Navigation* -> goto 'Appearance->Widgets' and **drag&drop** default widgets or widgets provided by plugins. 
See example below how to setup minicart, woo search and AWS search, TI wishlist.
<details id="widgets_example"><summary><strong>Widgets (search, minicart, wishlist) in menu GIF example</strong></summary>
  <img src="https://github.com/chyvak1831/starter_img/blob/master/menu_widgets.gif?raw=true" alt="Menu Image Icon">
</details>

**IV)** **Nested menu settings**.
<details><summary><strong>Categories widget, nested menu settings GIF example</strong></summary>
  <img src="https://github.com/chyvak1831/starter_img/blob/master/menu_widgets.gif?raw=true" alt="Menu Image Icon">
</details>

**IV)** Add one more level menu (top).
<details><summary><strong>Top menu GIF example</strong></summary>
  <img src="https://github.com/chyvak1831/starter_img/blob/master/menu_top.gif?raw=true" alt="Menu Image Icon">
</details>

**V)** Add **mobile** menu.
<details><summary><strong>Mobile menu GIF example</strong></summary>
  <img src="https://github.com/chyvak1831/starter_img/blob/master/menu_mobile.gif?raw=true" alt="Mobile Menu">
</details>

***
<br>



# 📁 Theme structure

```bash
themes/starter/   # → Root of Starter theme
├── assets/                                 # → Theme assets: css, js, svg icons
│   ├── css/                                # → Autogenerated from scss/
│   ├── js/                                 # → Scripts
│   │   ├── blueimp/                        # → Fileuploader plugin
│   │   ├── modules/                        # → Custom script sources
│   │   │   ├── comment.js                  # → Script for comments
│   │   │   ├── common.js                   # → Different common functions
│   │   │   ├── filters.js                  # → Filter scripts (archive page)
│   │   │   ├── home_page.js                # → Custom homepage tpl scripts
│   │   │   ├── product_add_remove.js       # → Functions for add/remove button
│   │   │   ├── product_hover.js            # → Display image on product hover 
│   │   │   ├── single_product.js           # → Single product page functions
│   │   │   └── step_nav.js                 # → Script for faq prev/next navigation
│   │   ├── iosPreloadFix.js                # → Bugfix for replace 'preload' into 'stylesheet' in <link>
│   │   ├── list_plugins.js                 # → Collect plugins from node_modules/
│   │   ├── list_scripts.js                 # → Collect files from js/modules/
│   │   ├── plugins.js                      # → Autogenerated from list_plugins.js
│   │   └── scripts.js                      # → Autogenerated from list_scripts.js
│   ├── scss/                               # → Styles
│   │   ├── theme/                          # → All scss custom files
│   │   │   ├── components/                 # → Components
│   │   │   |   ├── _carousel.scss          # → Carousels
│   │   │   |   ├── _components.scss        # → Collect all component files
│   │   │   |   ├── _footer.scss            # → Footer
│   │   │   |   ├── _header.scss            # → Header
│   │   │   |   ├── _minicart.scss          # → Default woo widget minicart
│   │   │   |   ├── _modal.scss             # → Modal
│   │   │   |   └── _wishlist.scss          # → TI wishlist plugin styles
│   │   │   ├── mixins/                     # → Mixins
│   │   │   |   ├── _ellipsis.scss          # → Ellipsis mixin (i.e. 3 dots at the end ...)
│   │   │   |   ├── _flex_align.scss        # → Flex align mixin - widely used
│   │   │   |   ├── _img_item.scss          # → Make image centered and limited inside box
│   │   │   |   └── _mixins.scss            # → Collect all mixin files
│   │   │   ├── pages/                      # → Pages
│   │   │   |   ├── _faq.scss               # → FAQ page styles
│   │   │   |   ├── _home.scss              # → Custom homepage tpl styles
│   │   │   |   └── _pages.scss             # → Collect all page files
│   │   │   ├── snippets/                   # → Snippets
│   │   │   |   ├── _forms.scss             # → Form styles
│   │   │   |   ├── _images.scss            # → Image box classes for limit image size and object-fit
│   │   │   |   ├── _list.scss              # → Flex lists (for menus, social lists etc)
│   │   │   |   ├── _menus.scss             # → Menu prototyping styles
│   │   │   |   ├── _pagination.scss        # → WooCommerce pagination
│   │   │   |   ├── _scrollup.scss          # → Scrollup button
│   │   │   |   ├── _select2.scss           # → Select2: default woo component - used on checkout, account
│   │   │   |   ├── _snippets.scss          # → Collect all snippet files
│   │   │   |   └── _wp_accessibility.scss  # → Fork of twentyseventeen/style.css (2.0 Accessibility)
│   │   │   ├── woo/                        # → Woo
│   │   │   |   ├── _account.scss           # → Account pages
│   │   │   |   ├── _filters.scss           # → Filter - archive page
│   │   │   |   ├── _product_item.scss      # → Product item
│   │   │   |   ├── _rating.scss            # → Rating
│   │   │   |   ├── _single_product.scss    # → Single product styles
│   │   │   |   └── _woo.scss               # → Collect all woo files
│   │   │   ├── _common.scss                # → Common styles
│   │   │   └── _variables.scss             # → Bootstrap customization
│   │   ├── plugins.scss                    # → Bootstrap modules
│   │   ├── styles.scss                     # → Custom modules
│   │   └── wp_admin.scss                   # → Styles for wordpress admin
│   └── svg-icons.svg                       # → Svg icons - used for decor graphics in theme (i.e. not content)
├── inc/                                    # → PHP logic
│   ├── acf-json/                           # → Autogenerated ACF
│   ├── woocommerce/                        # → WooCommerce logic
│   │   ├── comment/                        # → Comment
│   │   │   ├── comment-backend.php         # → Comment logic
│   │   │   ├── comment-customizer.php      # → Customizer comment settings
│   │   │   └── comment.php                 # → Comment functions
│   │   ├── filter/                         # → Filter
│   │   │   ├── class-wc-widget-layered-nav.php # → Fork of default Widget filter
│   │   │   └── filter.php                  # → Filter functions
│   │   └── woocommerce.php                 # → Woo functions
│   ├── customizer.php                      # → WordPress customizer
│   ├── icon-functions.php                  # → Svg icon functions (fork of twentyseventeen/inc/icon-functions.php)
│   ├── image.php                           # → Image functions
│   ├── menu.php                            # → Menu functions
│   ├── recaptchalib.php                    # → Google recaptcha lib
│   ├── remove-wp-assets.php                # → Remove unnecessary WordPress assets
│   └── tiny-mce-advanced.php               # → WYSIWYG settings, improvements like font-family
├── node_modules/                           # → Autogenerated packages
├── templates/                              # → Page templates
│   ├── page-faq.php                        # → FAQ page template
│   └── page-home.php                       # → Home page template
├── woocommerce/                            # → WooCommerce/TI wishlist ovveride templates
│   ├── single-product/                     # → Single product template parts
│   │   │   ├── add-to-cart/                # → Add to cart templates
│   │   │   |   └── variation-add-to-cart-button.php  # → Variation woo ovverride
│   │   │   ├── related.php                 # → Related products woo ovverride
│   │   │   └── up-sells.php                # → Upsells woo ovverride
│   ├── archive-product.php                 # → Archive template
│   ├── content-widget-price-filter.php     # → Price filter template
│   ├── product-searchform.php              # → Search form template
│   ├── single-product.php                  # → Single product template
│   └── ti-wishlist-product-counter.php     # → TI wishlist plugin counter template
├── woocommerce-custom/                     # → Custom additional templates
│   ├── comment/                            # → Comment files
│   │   ├── comment-form.php                # → Comment form
│   │   ├── comment-image-modal.php         # → Comment image modal (single page)
│   │   ├── comment-item.php                # → Comment item (single page)
│   │   └── comment-section.php             # → Whole comment section on single page
│   ├── global/                             # → Different global template parts
│   │   ├── add-to-cart.php                 # → Global add to cart button
│   │   ├── product-item.php                # → Global product item
│   │   └── rating.php                      # → Rating template
│   └── single-image-modal.php              # → Single image modal template
├── 404.php                                 # → 404 page template
├── config.js                               # → Configs for gulpfile.js
├── footer.php                              # → Footer template
├── functions.php                           # → Theme functions
├── gulpfile.js                             # → Gulp tasks
├── header.php                              # → Header template
├── index.php                               # → Theme default index file
├── package.json                            # → Node.js dependencies and scripts
├── page.php                                # → Default page template
├── README.md                               # → Readme (this current file)
├── screenshot.jpg                          # → Theme screenshot for WP admin
└── style.css                               # → Theme meta information
```
***
<br>



# 🤝 Contributing
Please open an issue first to discuss what you would like to change.
***
<br>



# 📘 License
[MIT](https://choosealicense.com/licenses/mit/)
