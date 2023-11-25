import WebFont from 'webfontloader';

export default (() => {
  WebFont.load({
    google: {
      families: ['Roboto:400,700', 'Roboto+Condensed:400']
    }
  });
})();
