const eleventyPluginFilesMinifier = require("@sherby/eleventy-plugin-files-minifier");
const Image = require('@11ty/eleventy-img');

module.exports = function(eleventyConfig) {

      // Filter price
        eleventyConfig.addFilter("formatPrice", function(value) {
          if (typeof value === "number") {
            return `${value} zł`;
          } else {
            return value;
          }
        });

    eleventyConfig.addPassthroughCopy("./src/static/css");
    eleventyConfig.addPassthroughCopy("./src/assets/js");
    eleventyConfig.addPassthroughCopy("./src/assets/img");
    eleventyConfig.addPassthroughCopy("./src/assets/video");
    eleventyConfig.addPassthroughCopy("./src/assets/font");
    eleventyConfig.addPassthroughCopy("./src/admin");
    eleventyConfig.addPassthroughCopy("./src/service_phone/img");
    eleventyConfig.addPassthroughCopy("./src/service_tablet/img");
    eleventyConfig.addPassthroughCopy("./src/service_computer/img");
    eleventyConfig.addPassthroughCopy("./src/service_laptop/img");
    eleventyConfig.addPassthroughCopy("./src/products/img");
    eleventyConfig.addWatchTarget("./src/assets/sass");

    eleventyConfig.addPlugin(eleventyPluginFilesMinifier);

    // Collections
    eleventyConfig.addCollection('posts', function(collectionApi) {
      return collectionApi.getFilteredByGlob('src/blog/**/*.md').reverse();
    });

    eleventyConfig.addCollection('products', function(collectionApi) {
      return collectionApi.getFilteredByGlob('src/products/**/*.md').reverse();
    });


    eleventyConfig.addCollection('services', function(collectionApi) {
      return collectionApi.getFilteredByGlob('src/services/**/*.md').reverse();
    });

    eleventyConfig.addCollection('services_computer', function(collectionApi) {
      return collectionApi.getFilteredByGlob('src/service_computer/**/*.md').reverse();
    });

    eleventyConfig.addCollection('services_tablet', function(collectionApi) {
      return collectionApi.getFilteredByGlob('src/service_tablet/**/*.md').reverse();
    });

    eleventyConfig.addCollection('services_phone', function(collectionApi) {
      return collectionApi.getFilteredByGlob('src/service_phone/**/*.md').reverse();
    });

    eleventyConfig.addCollection('services_laptop', function(collectionApi) {
      return collectionApi.getFilteredByGlob('src/service_laptop/**/*.md').reverse();
    });

    eleventyConfig.addNunjucksAsyncShortcode('Image', async (src, alt) => {
      if (!alt) {
        throw new Error(`Missing \`alt\` on myImage from: ${src}`);
      }
  
      let stats = await Image(src, {
        widths: [25, 320, 640, 960, 1200, 1800, 2400],
        formats: ['jpeg', 'webp'],
        urlPath: '/assets/img/',
        outputDir: './public/assets/img/',
      });
  
      let lowestSrc = stats['jpeg'][0];
  
      const srcset = Object.keys(stats).reduce(
        (acc, format) => ({
          ...acc,
          [format]: stats[format].reduce(
            (_acc, curr) => `${_acc} ${curr.srcset} ,`,
            '',
          ),
        }),
        {},
      );
  
      const source = `<source type="image/webp" srcset="${srcset['webp']}" >`;
  
      const img = `<img
        loading="lazy"
        alt="${alt}"
        src="${lowestSrc.url}"
        sizes='(min-width: 1024px) 1024px, 100vw'
        srcset="${srcset['jpeg']}"
        width="${lowestSrc.width}"
        height="${lowestSrc.height}">`;
  
      return `<div class="image-wrapper"><picture> ${source} ${img} </picture></div>`;
    });

    // Dodaj filtr dla prefiksu "zł"
      eleventyConfig.addFilter("addPrefix", function(value) {
    // Sprawdź, czy wartość jest liczbą
        if (typeof value === 'number') {
            return `${value} zł`;
        }
        return value;
    });

    // Date
    eleventyConfig.addFilter('dateDisplay', require('./src/filters/date-display.js'));
    eleventyConfig.addShortcode("year", () => `${new Date().getFullYear()}`);
  

    return {
      dir: {
        input: "src",
        output: "public",
        includes: "includes",
      }
    }
  };