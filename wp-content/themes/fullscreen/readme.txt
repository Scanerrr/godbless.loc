### About ###

Fullscreen is a one-column photography and multimedia theme that can be used for portfolios, photoblogs, videoblogs, and virtually anything else where you want your content to be front and center. It provides visual artists a unique way of presenting their latest work online using a minimalist side-scrolling homepage.


### Installation ###

1. Download the zip file from your [members dashboard](https://graphpaperpress.com/dashboard/). This will always be the most current version of the theme.
2. Log in to your WordPress dashboard. This can be found at yourdomain.com/wp-admin
3. Go to Appearance &gt; Themes and click on the *Install Themes* tab
4. Click on the *Upload* link
5. Upload the zip file that you downloaded from your members dashboard and click *Install Now*
6. Click *Activate* to use the theme you just installed.

![installing your Graph Paper Press theme](http://graphpaperpress.s3.amazonaws.com/images/instructions/install_themes.png)

For more details about installing your themes, please view [Installing Your Theme](http://graphpaperpress.com/support/installing-your-theme/)


### Demo content ###

Optional: You can download a demo content file [here](http://graphpaperpress-demo-content.s3.amazonaws.com/fullframe.xml) that you can import in Tools > Import.


### Media Settings ###

You will want to change your media settings to ensure that your images are cropped to the correct sizes. You can do this in Settings &gt; Media. 

On this page, change your media settings to:

* Thumbnail size
	* Width: 200
	* Height: 200
	* [checked] Crop thumbnails to exact dimensions (normally thumbnails are proportional)
* Medium size
	* Max Width: 590
	* Max Height: 0
* Large size
	* Max Width: 950
	* Max Height: 0
* Embeds
	* [checked] When possible, embed the media content from a URL directly onto the page. For example: links to Flickr and YouTube.
	* Maximum embed size
		* Width: 590
		* Height: 0

*Please Note: If you are switching from another theme, you will want to install and run the [Regenerate Thumbnails](http://wordpress.org/extend/plugins/regenerate-thumbnails/) WordPress plugin to resize your existing images.*


### Theme Customizer ###

With the Theme Customizer, you can set your title and tagline, assign your menus, add fonts, add a background image, and choose a static home page. You can preview your changes by clicking the Customize link below your active theme on your Appearance &gt; Themes page.

*Please note: Setting a static home page will remove the default homepage layout built into the theme. You must keep this set to* Display Latest Posts *to display the homepage options.*


### Theme Options ###

Go to Appearance &gt; Theme Options to select the category that will be featured on the home page and set how many thumbnails will appear in the top row. The number of thumbnails on the bottom row will adjust to match the width of the top row. You can also upload a logo and favicon, select your fonts, and add custom CSS. Styles added here will not be deleted when you update your theme.

CSS creates the style of your site. For example, to hide the description of your site, simply paste this code into the custom CSS box: 
`#site-description { display: none; }`.

#### Add a Blog Page ####

You may also want to create a Blog page to display all of your blog posts on your site. To do this, you can create a page called Blog and assign it to the Blog page template or the Blog with Sidebar page template. All of your posts will appear on this page.

*Please Note: Do* not *set this page as the page to display your blog posts in Settings > Reading or in the Theme Customizer as this will break the page template's code and your posts will not appear.*

#### Inserting a Gallery into a Post or Page ####

1. Click the Add Media button to launch the Media Uploader tool.
2. Click the Create Gallery option.
3. You can choose to upload images from your computer or you can use images that already exist in your Media Library. You cannot use an image from a URL on the web in your gallery.
4. If you are uploading images, click the Select Files button and navigate to each of your images on your computer. Click the Open button to open each image.
5. Once each of your images has been uploaded, you will have the option to add a title, caption, alternative text and description.
6. After you have added all of the images you wish to display in the gallery, switch to your media library tab and select those images.
7. Then, click the Create a New Gallery button.
8. Set a featured image for your Gallery.


### Widgets ###

This theme supports widgetized areas. For more detail about adding widgets to your site, please read [Adding Widgets](http://graphpaperpress.com/support/using-widgets/).


### Menus ###

Our themes use WordPress�s custom menus option. These can be created in Appearance > Menus. To add a new menu to your site:

1. Go to Appearance > Menus.
2. Create a new menu item by clicking the + tab.
3. Select the pages you want to display in your menu and click the Add to Menu button. If you do not see the type of page (category, tag, portfolio, gallery, etc) you want to display, click the Screen Options link at the top of the page and make sure the page type is checked.
4. Once you have set your menu as you want it, click the Save Menu button.
5. Then, assign that menu to your desired theme location to ensure your menu appears where you want it and click Save.

![Add a Custom Menu](http://graphpaperpress.s3.amazonaws.com/images/instructions/custom_menu.jpg)


### Always Set Featured Images ###

This theme relies heavily on Featured Images. If your post is missing a Featured Image, the post may not appear on the homepage or on archive pages. 

To choose the image you want to set as a featured image for this post and click the *Set as Featured Image* button. For best results use images that are at least 320 px wide.

![Add a Featured Image](http://graphpaperpress.s3.amazonaws.com/images/instructions/featured_image.png)


### Page Templates ###

This theme provides four page templates: Default, Page with Sidebar, Blog, and Blog with Sidebar.

1. The Default page template is the standard page layout, which spans the full-width of the site.
2. The Page with Sidebar page template adds the sidebar to your page.
3. The Blog page template will display all of your posts on the page. The page spans the full-width of the site. You can determine how many posts will appear on each page before the 'Older Entries' link in Settings &gt; Reading, by setting a value for 'Blog Pages Display at Most'.
3. The Blog with Sidebar page template works the same as the Blog page template, but it also adds a Sidebar.


### Embed Multimedia into Posts or Pages ###

#### Externally hosted Video ####

For externally hosted videos (for example a YouTube or Vimeo video), you can directly paste the link of your video page into the content editor. You do not have to paste the embed code. WordPress will automatically embed the video from the link.

You can easily embed videos from a Video hosting service such as Vimeo or YouTube into your posts or pages.

To add a video:

1. From your WordPress dashboard, add a new post or page (or edit an existing post or page).
2. Paste in your video�s URL, for example https://vimeo.com/31985752.
3. Publish or Update your post or page.

*Please note: If your video is not appearing correctly, remove the �s� from the URL, so https becomes http.*

#### Self-hosted Video ####

If you want to self-host your own videos, you can use the built-in FLV video player. Self-hosting your own videos is more complex, and requires some knowledge of file compression, codecs, using custom fields, CDNs, and video file streaming.

To add a video to a Post or Page, create a custom field called `video` and add the complete path your video's file in the field's value box. The combination wil appear like this:

`video | http://your-domain.com/path/to/your/video/file.flv`

To add a thumbnail to your video player, create a custom field called `video-thumb` and add the complete path to your thumbnail image in the field's value box. The combination will appear like this:

`video-thumb | http://your-domain.com/path/to/your/video/thumbnail.jpg`

If you wish to add multiple videos, enter one custom field for each video and thumbnail. For example:

* `video | http://your-domain.com/path/to/your/video/file.flv`
* `video-thumb | http://your-domain.com/path/to/your/video/thumbnail.jpg`
* `video | http://your-domain.com/path/to/your/video/file-2.flv`
* `video-thumb | http://your-domain.com/path/to/your/video/thumbnail-2.jpg`

We do not recommend streaming large files (videos, photos, audio, etc.) from the same server that hosts your website. We recommend using a file-streaming server or integrating with a third-party provider, such as Amazon Web Services.

To display mobile-friendly video files to users with Flash either disabled or not available, first enable the Mobile Video option on the Theme Options page. Then, follow these instructions:

1. Compress your video file into one of the recommended mobile-friendly video formats.
2. Upload the file to your server using your favorite method. Use FTP for large files. Use WordPress's built-in media uploader tool for small files.
3. Copy and paste the file's URL into a custom field called iphone.
4. If you haven't done so already, add a video thumbnail. You can do this the same way that you added regular thumbnails, except you will want to add an image large enough to fit the maximum size of the video player. If you have the sidebar enabled, use the 620px wide image. For sites with sidebars disabled, use the 940px wide image. Add the video thumbnail to a custom field called video-thumb.


### Installation Troubleshooting ###
 
If you've performed a clean install of the theme and are still having issues, check the following recommendations:
* Ensure you are using the latest version of Fullscreen.
* Ensure your file permissions are set correctly. On most servers, the theme files permissions should be set to 644 and folders should be set to 755.
* Ensure your theme folder is named `fullscreen`, with no extra spaces, characters, or uppercase letters. Also ensure that there is not a second folder called `fullscreen` inside the first.
* Fullscreen uses jQuery for much of its functionality. If your theme appears broken or unresponsive, you likely have a JavaScript conflict with one of your plugins. Deactivate **all** of your plugins. If that resolves the issue, reactivate them one at a time until you find the one causing the conflict.

### Theme Internationalization ###

Fullscreen is currently only available in English (US). It contains a default.pot file which you can use to translate to any other language you want.  See [WordPress in Your Language](http://codex.wordpress.org/WordPress_in_Your_Language) for more information about translating your version of Uno into another language.