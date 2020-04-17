<?php
// \!/~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\!/
//     DON'T MODIFY THIS FILE, AUTOGENERATED
// \!/~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\!/

// change "/wp-json" path to "/api"
function set_api_slug($slug) { return 'api'; }
add_filter('rest_url_prefix', 'set_api_slug');

//
// Load react app
//
add_action('wp_enqueue_scripts', function () {
    //
    // clear all javascript and css
    //
    global $wp_styles;
    global $wp_scripts;
    $wp_styles->queue = [];
    $wp_scripts->queue = [];

    //
    // Load react scripts
    //
    $theme_path = get_template_directory();
    $manifest_path = $theme_path . '/build/asset-manifest.json';
    $asset_manifest = json_decode(file_get_contents($manifest_path), true)['files'];

    $main_css = $asset_manifest['main.css'];
    $main_js = $asset_manifest['main.js'];
    $runtime_js = $asset_manifest['runtime-main.js'];

    if (isset($main_css)) {
        wp_enqueue_style('cra-css', $main_css);
    }
    if (isset($runtime_js)) {
        wp_enqueue_script('cra-runtime', $runtime_js, [], null, true);
    }
    if (isset($main_js)) {
        wp_enqueue_script('cra-js', $main_js, ['cra-runtime'], null, true);
    }

    // from https://www.digitalocean.com/community/tutorials/how-to-embed-a-react-application-in-wordpress-on-ubuntu-18-04
    foreach ($asset_manifest as $key => $value) {
        if (preg_match('@static/js/(.*)\.chunk\.js@', $key, $matches)) {
            if ($matches && is_array($matches) && count($matches) === 2) {
                $name = "cra-" . preg_replace('/[^A-Za-z0-9_]/', '-', $matches[1]);
                wp_enqueue_script($name, get_site_url() . $value, ['cra-js'], null, true);
            }
        }

        if (preg_match('@static/css/(.*)\.chunk\.css@', $key, $matches)) {
            if ($matches && is_array($matches) && count($matches) == 2) {
                $name = "cra-" . preg_replace('/[^A-Za-z0-9_]/', '-', $matches[1]);
                wp_enqueue_style($name, get_site_url() . $value, ['cra-css'], null);
            }
        }
    }
});

function load_react_app()
{
    $build_path = parse_url(get_template_directory_uri() . '/build', PHP_URL_PATH); ?>
<!doctype html>
<html lang="en">

<head>
<meta content="width=device-width, initial-scale=1" name="viewport" />
  <?php wp_head(); ?>
</head>

<body>
  <noscript>You need to enable JavaScript to run this app.</noscript>
  <div id="root"></div>

  <script>!function(f){function e(e){for(var t,r,n=e[0],o=e[1],u=e[2],l=0,i=[];l<n.length;l++)r=n[l],Object.prototype.hasOwnProperty.call(a,r)&&a[r]&&i.push(a[r][0]),a[r]=0;for(t in o)Object.prototype.hasOwnProperty.call(o,t)&&(f[t]=o[t]);for(s&&s(e);i.length;)i.shift()();return c.push.apply(c,u||[]),p()}function p(){for(var e,t=0;t<c.length;t++){for(var r=c[t],n=!0,o=1;o<r.length;o++){var u=r[o];0!==a[u]&&(n=!1)}n&&(c.splice(t--,1),e=l(l.s=r[0]))}return e}var r={},a={1:0},c=[];function l(e){if(r[e])return r[e].exports;var t=r[e]={i:e,l:!1,exports:{}};return f[e].call(t.exports,t,t.exports,l),t.l=!0,t.exports}l.m=f,l.c=r,l.d=function(e,t,r){l.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:r})},l.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},l.t=function(t,e){if(1&e&&(t=l(t)),8&e)return t;if(4&e&&"object"==typeof t&&t&&t.__esModule)return t;var r=Object.create(null);if(l.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:t}),2&e&&"string"!=typeof t)for(var n in t)l.d(r,n,function(e){return t[e]}.bind(null,n));return r},l.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return l.d(t,"a",t),t},l.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},l.p="<?php echo $build_path; ?>";var t=this.webpackJsonphometown=this.webpackJsonphometown||[],n=t.push.bind(t);t.push=e,t=t.slice();for(var o=0;o<t.length;o++)e(t[o]);var s=n;p()}([])</script>
  <?php wp_footer(); ?>
</body>

</html>
<?php
}

// \!/~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\!/
//     DON'T MODIFY THIS FILE, AUTOGENERATED
// \!/~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\!/