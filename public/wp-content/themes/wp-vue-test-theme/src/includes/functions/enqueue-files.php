<?php

/*
* Loop through CSS and JS folder.
* Get only .css/.js files.
* Set dependencies depending on file name.
* Enqueue file.
*/

function enqueue_files() {

////////////////////////////////////////////////////////
/// CSS
	$dirCSS = new DirectoryIterator(get_stylesheet_directory() . '/css');

	foreach ($dirCSS as $file) {

		if( pathinfo($file, PATHINFO_EXTENSION) === 'css' ) {

			wp_enqueue_style( basename($file, '.css'), (get_template_directory_uri() . '/css/' . basename($file)),
							  false, null );
		}

	}


////////////////////////////////////////////////////////
/// JAVASCRIPT
	$dirJS = new DirectoryIterator(get_stylesheet_directory() . '/js');

	foreach ($dirJS as $file) {

		if( pathinfo($file, PATHINFO_EXTENSION) === 'js' ) {					// only get JS files

			$fullName = basename($file);
			$name = substr(basename($fullName), 0, strpos(basename($fullName), '.'));


		////////////////////////////////////////////////////////
		/// DEPENDENCIES >PHP 5.3


			switch($name) {

				case 'main':
					$deps = array('vendor');	break;

				default:
					$deps = null;				break;

			}


		////////////////////////////////////////////////////////
		/// ENQUEUE SCRIPT
			wp_enqueue_script( $name, get_template_directory_uri() . '/js/' . $fullName, $deps, null, true );


		}

	}




////////////////////////////////////////////////////////
/// DEREGISTER JQUERY
	if( !is_admin() ) {	wp_deregister_script('jquery'); }

}
add_action( 'wp_enqueue_scripts', 'enqueue_files' );


add_action( 'wp_head', function () { ?>
    <script type="text/javascript" id="__bs_script__">//<![CDATA[
        document.write("<script async src='http://HOST:3000/browser-sync/browser-sync-client.js'><\/script>".replace("HOST", location.hostname));
    //]]></script>
<?php }, 999);

// foreach ($dirJS as $file) {
//
// 	if( pathinfo($file, PATHINFO_EXTENSION) === 'js' ) {
//
// 		$fullName = basename($file);
// 		//echo $fullName;
// 		$name = substr($fullName, 0, strpos($fullName, '.')); // (string, start, length(string, position of character))
// 		//echo $name;
// 		$deps = ($name == 'main' ? 'vendor' : '');
// 		//echo $deps;
//
// 		wp_enqueue_script( $name, get_template_directory_uri() . '/js/' . $fullName, array($deps), null, true );
//
// 	}
//
// }
