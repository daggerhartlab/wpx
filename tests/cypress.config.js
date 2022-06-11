const { defineConfig } = require('cypress')
const fs = require('fs');

/*
 * Override some config options with a custom json file.
 */
let localConfig = {}
if (fs.existsSync(`${__dirname}/local.config.json`)) {
	localConfig = JSON.parse(fs.readFileSync(`${__dirname}/local.config.json`))
}

/*
 * Cypress config:
 */
module.exports = defineConfig({
	viewportHeight: localConfig.viewportHeight ? localConfig.viewportHeight : 900,
	viewportWidth: localConfig.viewportWidth ? localConfig.viewportWidth : 1201,
	e2e: {
		baseUrl: localConfig.baseUrl ? localConfig.baseUrl : 'https://wpx.lndo.site',
	},
})
