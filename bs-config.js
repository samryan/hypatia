module.exports = {
  proxy: "samryan.test",
  files: [
    "**/*.scss",
    "**/*.css",
    "**/*.php",
    "**/*.js",
    "!node_modules/**"
  ],
  notify: false,
  open: true,
  ghostMode: false
};
