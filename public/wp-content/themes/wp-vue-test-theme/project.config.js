////////////////////////////////
// VARIABLES
const wp   = true
const app  = true   // if true, uncomment MW in Webpack


////////////////////////////////////////////////////////////////
// SERVER
const serve = {
	ghostmode: false,
    open: false,
    //proxy: 'bp.local',   // uncomment if MAMP
	server: './build'      // set false if MAMP
}


////////////////////////////////////////////////////////////////
// README
const createReadme = res => {

	let today = new Date(),
			d = today.getDate(),
			m = today.getMonth() + 1,
			y = today.getFullYear();

	if( d < 10 ) d = '0' + d
	if( m < 10 ) m = '0' + m

	today = `${d}.${m}.${y}`

	return `
### ${res.project}
_${res.url}_
- - - -

> **Gestartet von:** ${res.author}\x20\x20
> **Angelegt am:** ${today}\x20\x20
> **URL:** ${res.url}\x20\x20
> **Server:** ${res.server}\x20\x20
> **CMS:** ${res.cms}\x20\x20

**Notizen:**
* Have a nice day!`

}


////////////////////////////////////////////////////////////////
// PATHS
const src = {
 favicons: 'src/assets/favicons',
	fonts: 'src/assets/fonts',
	icons: 'src/assets/icons',
	  img: 'src/assets/img',
	   js: 'src/js',
	 scss: 'src/scss'
}
const dest  = {
 favicons: 'build/assets/favicons',
   assets: 'build/assets',
	fonts: 'build/assets/fonts',
	  img: 'build/assets/img',
	   js: 'build/js',
	 scss: 'build/css'
}


////////////////////////////////////////////////////////////////
// THEME
const theme = `
/*
Theme Name: Boilerplate
Version: 1.0
Author: Pascal Klau <email@artofmyself.com>
Author URI: http://www.artofmyself.com
Description: Boilerplate WP Theme
*/`;


module.exports = {
	wp, app, serve, createReadme, src, dest, theme
}
