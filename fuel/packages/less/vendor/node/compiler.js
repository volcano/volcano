/**
 * FuelPHP LessCSS package implementation.
 *
 * @author     Kriansa
 * @version    2.0
 * @package    Fuel
 * @subpackage Less
 */

var less = require('../lessjs/lib/less');
var path = require('path');
var fs = require('fs');

// Input and output files
var input = process.argv[2];
var output = process.argv[3];

new(less.Parser)({
    paths: [path.dirname(input), path.dirname(output)],
    filename: input
}).parse(fs.readFileSync(input, 'utf-8'), function (error, tree) {
    if (error) {
        return console.error(JSON.stringify(error));
    }

    try {
        var css = tree.toCSS({
            compress: true,
            yuicompress: true
        }); // Minify CSS output

        // Output the css
        console.log(css);

    } catch (e) {
        console.error(JSON.stringify(e));
    }
});