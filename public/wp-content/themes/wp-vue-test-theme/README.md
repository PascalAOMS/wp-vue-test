
# Personal Boilerplate
_https://github.com/pascalaoms/boilerplate_
- - - -
![dependencies check](https://david-dm.org/pascalaoms/boilerplate.svg)
![dev dependencies check](https://david-dm.org/pascalaoms/boilerplate/dev-status.svg)
## Usage
```
sites  
newSite <project name>
```
```
npm i
npm run dev  
npm run build
```

Upload whole project. Check **project.config.js** for paths and servername.
```
npm run dev upload
```

---

### Icons
* save single icon SVG in **src/assets/icons**  
* Gulp task combines icons into single icon in **build/assets/icons.svg**
* If icons go inline, put them in **_Mat/img** and paste manually.
* Webpack alias for assets  
Reference icons like this:
```html
<use xlink:href="assets/icons.svg#squirrel"></use>
```

---

### Fonts
Too long install times for Gulp packages hence the global usage via Bash.  
This creates **WOFF** and **WOFF2** in the same folder.
```
convertFont path/to/font.ttf
```

---

### VueJS
**Web App development supported.**  
**Uncomment Middleware in Webpack and set app variable to true.**
* Live Reloading
* Hot Module Reloading  
* Images <10KB to inline Base64
* VueJS Templating
* Add these dependencies
```
yarn add vue vue-router && yarn add svg-url-loader url-loader vue-hot-reload-api vue-html-loader vue-loader
```
No Sass import in JS hence the missing of Sass loaders. Using own Sass modules.  
