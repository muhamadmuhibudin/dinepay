import "./bootstrap";
import "./vendor";
import "bootstrap/dist/js/bootstrap.bundle.min.js";
import "../lib/easing/easing.min.js";
import "../lib/waypoints/waypoints.min.js";

// Ensure jQuery global is initialized before loading jQuery plugins.
await import("../lib/lightbox/js/lightbox.min.js");
await import("../lib/owlcarousel/owl.carousel.min.js");
await import("./main");
