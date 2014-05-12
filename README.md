php-site-simulator
==================

Simulate a good (or bad) PHP website including variable HTTP Status Codes, caching TTLs, response times, etc.

The site simulate operates on two modes. One being a "good" or healthy site. The other being a "bad" or unhealthy site. A site may be unhealthy for a variety of reasons (not configured properly, not coded well, not using best caching practices, etc.). The simulator just pretends to be healthy or unhealthy and sends a corresponding level of 200s, 300s, 400s, 500s, etc.

In the event that the simulator is backed by a Varnish box it also will send out different cache-control-headers. So an unhealthy site will also include more hits going back to origin, whereas a healthy site will be well-cached in Varnish.

The simular will also send a marker event to a Graphite box when you toggle from good to bad mode to be able to visually represent in Graphite when a site switched modes.