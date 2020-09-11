/**
 * Copyright 2016 Google Inc. All rights reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
*/

// DO NOT EDIT THIS GENERATED OUTPUT DIRECTLY!
// This file should be overwritten as part of your build process.
// If you need to extend the behavior of the generated service worker, the best approach is to write
// additional code and include it using the importScripts option:
//   https://github.com/GoogleChrome/sw-precache#importscripts-arraystring
//
// Alternatively, it's possible to make changes to the underlying template file and then use that as the
// new base for generating output, via the templateFilePath option:
//   https://github.com/GoogleChrome/sw-precache#templatefilepath-string
//
// If you go that route, make sure that whenever you update your sw-precache dependency, you reconcile any
// changes made to this original template file with your modified copy.

// This generated service worker JavaScript will precache your site's resources.
// The code needs to be saved in a .js file at the top-level of your site, and registered
// from your pages in order to be used. See
// https://github.com/googlechrome/sw-precache/blob/master/demo/app/js/service-worker-registration.js
// for an example of how you can register this script and handle various service worker events.

/* eslint-env worker, serviceworker */
/* eslint-disable indent, no-unused-vars, no-multiple-empty-lines, max-nested-callbacks, space-before-function-paren, quotes, comma-spacing */
'use strict';

var precacheConfig = [["css/backend.css","869842b4b277902085949b2c12d75c16"],["css/frontend.css","d36581d89d52c67a7b56c36178939a5f"],["favicon.ico","d41d8cd98f00b204e9800998ecf8427e"],["fonts/vendor/@fortawesome/fontawesome-free/webfa-brands-400.eot","3165b14bbf3b64fca65829ecde6b800d"],["fonts/vendor/@fortawesome/fontawesome-free/webfa-brands-400.svg","f249e44df3044e7b0d665b550569ddf0"],["fonts/vendor/@fortawesome/fontawesome-free/webfa-brands-400.ttf","f2e186cfab4787d4ef6f1bb192aa9a1b"],["fonts/vendor/@fortawesome/fontawesome-free/webfa-brands-400.woff","457cb96b6191ed105c4fe8463957f70d"],["fonts/vendor/@fortawesome/fontawesome-free/webfa-brands-400.woff2","f861a57c52ef711cf807a3eec92c0e17"],["fonts/vendor/@fortawesome/fontawesome-free/webfa-regular-400.eot","a03df7ab0ffc96cabbfe3dc71c60baaa"],["fonts/vendor/@fortawesome/fontawesome-free/webfa-regular-400.svg","2fad4ee0a47f41bc76e21c2baf613182"],["fonts/vendor/@fortawesome/fontawesome-free/webfa-regular-400.ttf","2cd8d991e82712f1a5c5de8ee869ca74"],["fonts/vendor/@fortawesome/fontawesome-free/webfa-regular-400.woff","7ab2cb050690f93994c46258d49af5b6"],["fonts/vendor/@fortawesome/fontawesome-free/webfa-regular-400.woff2","bd52a727b5449dc3f8195b72c9c58341"],["fonts/vendor/@fortawesome/fontawesome-free/webfa-solid-900.eot","a547e21eceadf53602caf057be9ad9fd"],["fonts/vendor/@fortawesome/fontawesome-free/webfa-solid-900.svg","fdc155d57b7351ef85b3028ea3cfc048"],["fonts/vendor/@fortawesome/fontawesome-free/webfa-solid-900.ttf","5ee32f5c8598e1a63ddf1aad4ffe54f4"],["fonts/vendor/@fortawesome/fontawesome-free/webfa-solid-900.woff","657a469469a2fc38a2901c68a3d56512"],["fonts/vendor/@fortawesome/fontawesome-free/webfa-solid-900.woff2","2cd2be177470d5096992572176bbe76e"],["images/bg.jpg","3c6c036debafbaf3744fb8c22315f8b3"],["img/apple-touch-icon.png","dd4982cd76f68de9c6d6dd647673e66c"],["img/backend/avatars/1.jpg","4f7fdfc6675d0469eacc4d6c735219ac"],["img/backend/avatars/2.jpg","480fe440dc6b962a63b6ab017d145380"],["img/backend/avatars/3.jpg","73e3cc5256255d13f8ee6504e38e48f1"],["img/backend/avatars/4.jpg","75e0bbd2d3d2831a6d5e387d674a61db"],["img/backend/avatars/5.jpg","56fb19fbf7dde8f0d717681b39f0dee6"],["img/backend/avatars/6.jpg","6423e2e662718dd7f20fb7c89b742a9d"],["img/backend/avatars/7.jpg","f9e66d23438ea709be513b60f66dcb17"],["img/backend/avatars/8.jpg","960f2560c90216e7e7d715a3470d7080"],["img/backend/bg.jpg","3c6c036debafbaf3744fb8c22315f8b3"],["img/backend/brand/logo.svg","f7eb9aeadcf6dec16ce1df324c046dbc"],["img/backend/brand/logo_long.png","ab3450f13c0fd161f037a6c914201ab7"],["img/backend/brand/sygnet.svg","97e6bed8ea83257280184adfd91b619e"],["img/favicon-16x16.png","24f391b36c4379a6d8ced7e720de7d2f"],["img/favicon-192x192.png","73ad378756e6f756a4529668d7425d90"],["img/favicon-32x32.png","72e9598da8480763975e7c481f2acf24"],["img/favicon-512x512.png","050e95f9ae0b3fe6d2d9127a844e11a7"],["img/favicon.ico","95014f81babd678141c01135bc6312bf"],["index.php","aec1e9be7637bf5a2f31d2baa6836951"],["js/backend.js","c5bb5d67b74cd4c1e21c6698937ad970"],["js/backend.js.map","08d020121f5879755fc28dc5cc1db03d"],["js/frontend.js","5a68f4760f45bd9063ca8d56d63890a9"],["js/frontend.js.map","d8ac8d59c2b27795f9528f5a0d839b5b"],["js/manifest.js","d91051ea7d0c9bd1981e0c1e15cf1bf2"],["js/manifest.js.map","a07956f82042cc418451decae18af4ee"],["js/vendor.js","05691c15bff852edc413a261bb572ec1"],["js/vendor.js.map","fe01e99f71c8aeb4e99b89443205a811"],["manifest.json","ee3fd884eb4945a33e33ec36b2290660"],["mix-manifest.json","a8db47f2cd3b322db28defee7cc7fc90"],["robots.txt","b6216d61c03e6ce0c9aea6ca7808f7ca"],["script.js","65245c319cd13a3c04867cc49436a464"],["web.config","167afcb2564b1f6fd77c952e6b0b7b8d"]];
var cacheName = 'sw-precache-v3-sw-precache-' + (self.registration ? self.registration.scope : '');


var ignoreUrlParametersMatching = [/^utm_/];



var addDirectoryIndex = function(originalUrl, index) {
    var url = new URL(originalUrl);
    if (url.pathname.slice(-1) === '/') {
      url.pathname += index;
    }
    return url.toString();
  };

var cleanResponse = function(originalResponse) {
    // If this is not a redirected response, then we don't have to do anything.
    if (!originalResponse.redirected) {
      return Promise.resolve(originalResponse);
    }

    // Firefox 50 and below doesn't support the Response.body stream, so we may
    // need to read the entire body to memory as a Blob.
    var bodyPromise = 'body' in originalResponse ?
      Promise.resolve(originalResponse.body) :
      originalResponse.blob();

    return bodyPromise.then(function(body) {
      // new Response() is happy when passed either a stream or a Blob.
      return new Response(body, {
        headers: originalResponse.headers,
        status: originalResponse.status,
        statusText: originalResponse.statusText
      });
    });
  };

var createCacheKey = function(originalUrl, paramName, paramValue,
                           dontCacheBustUrlsMatching) {
    // Create a new URL object to avoid modifying originalUrl.
    var url = new URL(originalUrl);

    // If dontCacheBustUrlsMatching is not set, or if we don't have a match,
    // then add in the extra cache-busting URL parameter.
    if (!dontCacheBustUrlsMatching ||
        !(url.pathname.match(dontCacheBustUrlsMatching))) {
      url.search += (url.search ? '&' : '') +
        encodeURIComponent(paramName) + '=' + encodeURIComponent(paramValue);
    }

    return url.toString();
  };

var isPathWhitelisted = function(whitelist, absoluteUrlString) {
    // If the whitelist is empty, then consider all URLs to be whitelisted.
    if (whitelist.length === 0) {
      return true;
    }

    // Otherwise compare each path regex to the path of the URL passed in.
    var path = (new URL(absoluteUrlString)).pathname;
    return whitelist.some(function(whitelistedPathRegex) {
      return path.match(whitelistedPathRegex);
    });
  };

var stripIgnoredUrlParameters = function(originalUrl,
    ignoreUrlParametersMatching) {
    var url = new URL(originalUrl);
    // Remove the hash; see https://github.com/GoogleChrome/sw-precache/issues/290
    url.hash = '';

    url.search = url.search.slice(1) // Exclude initial '?'
      .split('&') // Split into an array of 'key=value' strings
      .map(function(kv) {
        return kv.split('='); // Split each 'key=value' string into a [key, value] array
      })
      .filter(function(kv) {
        return ignoreUrlParametersMatching.every(function(ignoredRegex) {
          return !ignoredRegex.test(kv[0]); // Return true iff the key doesn't match any of the regexes.
        });
      })
      .map(function(kv) {
        return kv.join('='); // Join each [key, value] array into a 'key=value' string
      })
      .join('&'); // Join the array of 'key=value' strings into a string with '&' in between each

    return url.toString();
  };


var hashParamName = '_sw-precache';
var urlsToCacheKeys = new Map(
  precacheConfig.map(function(item) {
    var relativeUrl = item[0];
    var hash = item[1];
    var absoluteUrl = new URL(relativeUrl, self.location);
    var cacheKey = createCacheKey(absoluteUrl, hashParamName, hash, false);
    return [absoluteUrl.toString(), cacheKey];
  })
);

function setOfCachedUrls(cache) {
  return cache.keys().then(function(requests) {
    return requests.map(function(request) {
      return request.url;
    });
  }).then(function(urls) {
    return new Set(urls);
  });
}

self.addEventListener('install', function(event) {
  event.waitUntil(
    caches.open(cacheName).then(function(cache) {
      return setOfCachedUrls(cache).then(function(cachedUrls) {
        return Promise.all(
          Array.from(urlsToCacheKeys.values()).map(function(cacheKey) {
            // If we don't have a key matching url in the cache already, add it.
            if (!cachedUrls.has(cacheKey)) {
              var request = new Request(cacheKey, {credentials: 'same-origin'});
              return fetch(request).then(function(response) {
                // Bail out of installation unless we get back a 200 OK for
                // every request.
                if (!response.ok) {
                  throw new Error('Request for ' + cacheKey + ' returned a ' +
                    'response with status ' + response.status);
                }

                return cleanResponse(response).then(function(responseToCache) {
                  return cache.put(cacheKey, responseToCache);
                });
              });
            }
          })
        );
      });
    }).then(function() {
      
      // Force the SW to transition from installing -> active state
      return self.skipWaiting();
      
    })
  );
});

self.addEventListener('activate', function(event) {
  var setOfExpectedUrls = new Set(urlsToCacheKeys.values());

  event.waitUntil(
    caches.open(cacheName).then(function(cache) {
      return cache.keys().then(function(existingRequests) {
        return Promise.all(
          existingRequests.map(function(existingRequest) {
            if (!setOfExpectedUrls.has(existingRequest.url)) {
              return cache.delete(existingRequest);
            }
          })
        );
      });
    }).then(function() {
      
      return self.clients.claim();
      
    })
  );
});


self.addEventListener('fetch', function(event) {
  if (event.request.method === 'GET') {
    // Should we call event.respondWith() inside this fetch event handler?
    // This needs to be determined synchronously, which will give other fetch
    // handlers a chance to handle the request if need be.
    var shouldRespond;

    // First, remove all the ignored parameters and hash fragment, and see if we
    // have that URL in our cache. If so, great! shouldRespond will be true.
    var url = stripIgnoredUrlParameters(event.request.url, ignoreUrlParametersMatching);
    shouldRespond = urlsToCacheKeys.has(url);

    // If shouldRespond is false, check again, this time with 'index.html'
    // (or whatever the directoryIndex option is set to) at the end.
    var directoryIndex = 'index.html';
    if (!shouldRespond && directoryIndex) {
      url = addDirectoryIndex(url, directoryIndex);
      shouldRespond = urlsToCacheKeys.has(url);
    }

    // If shouldRespond is still false, check to see if this is a navigation
    // request, and if so, whether the URL matches navigateFallbackWhitelist.
    var navigateFallback = '';
    if (!shouldRespond &&
        navigateFallback &&
        (event.request.mode === 'navigate') &&
        isPathWhitelisted([], event.request.url)) {
      url = new URL(navigateFallback, self.location).toString();
      shouldRespond = urlsToCacheKeys.has(url);
    }

    // If shouldRespond was set to true at any point, then call
    // event.respondWith(), using the appropriate cache key.
    if (shouldRespond) {
      event.respondWith(
        caches.open(cacheName).then(function(cache) {
          return cache.match(urlsToCacheKeys.get(url)).then(function(response) {
            if (response) {
              return response;
            }
            throw Error('The cached response that was expected is missing.');
          });
        }).catch(function(e) {
          // Fall back to just fetch()ing the request if some unexpected error
          // prevented the cached response from being valid.
          console.warn('Couldn\'t serve response for "%s" from cache: %O', event.request.url, e);
          return fetch(event.request);
        })
      );
    }
  }
});







