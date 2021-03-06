var SelectPure = function() {
  "use strict";

  function s(e, t) {
    if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
  }

  function i(e, t) {
    for (var n = 0; n < t.length; n++) {
      var i = t[n];
      i.enumerable = i.enumerable || !1, i.configurable = !0, "value" in i && (i.writable = !0), Object.defineProperty(e, i.key, i)
    }
  }

  function e(e, t, n) {
    return t && i(e.prototype, t), n && i(e, n), e
  }

  function t(t, e) {
    var n = Object.keys(t);
    if (Object.getOwnPropertySymbols) {
      var i = Object.getOwnPropertySymbols(t);
      e && (i = i.filter(function(e) {
        return Object.getOwnPropertyDescriptor(t, e).enumerable
      })), n.push.apply(n, i)
    }
    return n
  }

  function o(s) {
    for (var e = 1; e < arguments.length; e++) {
      var o = null != arguments[e] ? arguments[e] : {};
      e % 2 ? t(Object(o), !0).forEach(function(e) {
        var t, n, i;
        t = s, i = o[n = e], n in t ? Object.defineProperty(t, n, {
          value: i,
          enumerable: !0,
          configurable: !0,
          writable: !0
        }) : t[n] = i
      }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(s, Object.getOwnPropertyDescriptors(o)) : t(Object(o)).forEach(function(e) {
        Object.defineProperty(s, e, Object.getOwnPropertyDescriptor(o, e))
      })
    }
    return s
  }

  function l(e) {
    return function(e) {
      if (Array.isArray(e)) return a(e)
    }(e) || function(e) {
      if ("undefined" != typeof Symbol && Symbol.iterator in Object(e)) return Array.from(e)
    }(e) || function(e, t) {
      if (!e) return;
      if ("string" == typeof e) return a(e, t);
      var n = Object.prototype.toString.call(e).slice(8, -1);
      "Object" === n && e.constructor && (n = e.constructor.name);
      if ("Map" === n || "Set" === n) return Array.from(n);
      if ("Arguments" === n || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return a(e, t)
    }(e) || function() {
      throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")
    }()
  }

  function a(e, t) {
    (null == t || t > e.length) && (t = e.length);
    for (var n = 0, i = new Array(t); n < t; n++) i[n] = e[n];
    return i
  }
  var n = {
      value: "data-value",
      disabled: "data-disabled",
      class: "class",
      type: "type"
    },
    c = function() {
      function i(e) {
        var t = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : {},
          n = 2 < arguments.length && void 0 !== arguments[2] ? arguments[2] : {};
        return s(this, i), this._node = e instanceof HTMLElement ? e : document.createElement(e), this._config = {
          i18n: n
        }, this._setAttributes(t), t.textContent && this._setTextContent(t.textContent), this
      }
      return e(i, [{
        key: "get",
        value: function() {
          return this._node
        }
      }, {
        key: "append",
        value: function(e) {
          return this._node.appendChild(e), this
        }
      }, {
        key: "addClass",
        value: function(e) {
          return this._node.classList.add(e), this
        }
      }, {
        key: "removeClass",
        value: function(e) {
          return this._node.classList.remove(e), this
        }
      }, {
        key: "toggleClass",
        value: function(e) {
          return this._node.classList.toggle(e), this
        }
      }, {
        key: "addEventListener",
        value: function(e, t) {
          return this._node.addEventListener(e, t), this
        }
      }, {
        key: "removeEventListener",
        value: function(e, t) {
          return this._node.removeEventListener(e, t), this
        }
      }, {
        key: "setText",
        value: function(e) {
          return this._setTextContent(e), this
        }
      }, {
        key: "getHeight",
        value: function() {
          return window.getComputedStyle(this._node).height
        }
      }, {
        key: "setBottom",
        value: function(e) {
          return this._node.style.bottom = "".concat(e, "px"), this
        }
      }, {
        key: "focus",
        value: function() {
          return this._node.focus(), this
        }
      }, {
        key: "_setTextContent",
        value: function(e) {
          this._node.textContent = e
        }
      }, {
        key: "_setAttributes",
        value: function(e) {
          for (var t in e) n[t] && e[t] && this._setAttribute(n[t], e[t])
        }
      }, {
        key: "_setAttribute",
        value: function(e, t) {
          this._node.setAttribute(e, t)
        }
      }]), i
    }(),
    r = {
      select: "select-pure__select",
      dropdownShown: "select-pure__select--opened",
      multiselect: "select-pure__select--multiple",
      label: "select-pure__label",
      placeholder: "select-pure__placeholder",
      dropdown: "select-pure__options",
      option: "select-pure__option",
      optionDisabled: "select-pure__option--disabled",
      autocompleteInput: "select-pure__autocomplete",
      selectedLabel: "select-pure__selected-label",
      selectedOption: "select-pure__option--selected",
      placeholderHidden: "select-pure__placeholder--hidden",
      optionHidden: "select-pure__option--hidden"
    };
  return function() {
    function n(e, t) {
      s(this, n), this._config = o({}, t, {
        classNames: o({}, r, {}, t.classNames),
        disabledOptions: []
      }), this._state = {
        opened: !1
      }, this._icons = [], this._boundHandleClick = this._handleClick.bind(this), this._boundUnselectOption = this._unselectOption.bind(this), this._boundSortOptions = this._sortOptions.bind(this), this._body = new c(document.body), this._create(e), this._config.value && this._setValue()
    }
    return e(n, [{
      key: "value",
      value: function() {
        return this._config.value
      }
    }, {
      key: "reset",
      value: function() {
        this._config.value = this._config.multiple ? [] : null, this._setValue()
      }
    }, {
      key: "_create",
      value: function(e) {
        var t = "string" == typeof e ? document.querySelector(e) : e;
        this._parent = new c(t), this._select = new c("div", {
          class: this._config.classNames.select
        }), this._label = new c("span", {
          class: this._config.classNames.label
        }), this._optionsWrapper = new c("div", {
          class: this._config.classNames.dropdown
        }), this._config.multiple && this._select.addClass(this._config.classNames.multiselect), this._options = this._generateOptions(), this._select.addEventListener("click", this._boundHandleClick), this._select.append(this._label.get()), this._select.append(this._optionsWrapper.get()), this._parent.append(this._select.get()), this._placeholder = new c("span", {
          class: this._config.classNames.placeholder,
          textContent: this._config.placeholder
        }), this._select.append(this._placeholder.get())
      }
    }, {
      key: "_generateOptions",
      value: function() {
        var n = this;
        return this._config.autocomplete && (this._autocomplete = new c("input", {
          class: this._config.classNames.autocompleteInput,
          type: "text"
        }), this._autocomplete.addEventListener("input", this._boundSortOptions), this._optionsWrapper.append(this._autocomplete.get())), this._config.options.map(function(e) {
          var t = new c("div", {
            class: "".concat(n._config.classNames.option).concat(e.disabled ? " " + n._config.classNames.optionDisabled : ""),
            value: e.value,
            textContent: e.label,
            disabled: e.disabled
          });
          return e.disabled && n._config.disabledOptions.push(String(e.value)), n._optionsWrapper.append(t.get()), t
        })
      }
    }, {
      key: "_handleClick",
      value: function(t) {
        if (t.stopPropagation(), t.target.className !== this._config.classNames.autocompleteInput) {
          if (this._state.opened) {
            var e = this._options.find(function(e) {
              return e.get() === t.target
            });
            return e && this._setValue(e.get().getAttribute("data-value"), !0), this._select.removeClass(this._config.classNames.dropdownShown), this._body.removeEventListener("click", this._boundHandleClick), this._select.addEventListener("click", this._boundHandleClick), void(this._state.opened = !1)
          }
          t.target.className !== this._config.icon && (this._select.addClass(this._config.classNames.dropdownShown), this._body.addEventListener("click", this._boundHandleClick), this._select.removeEventListener("click", this._boundHandleClick), this._state.opened = !0, this._autocomplete && this._autocomplete.focus())
        }
      }
    }, {
      key: "_setValue",
      value: function(e, t, n) {
        var i = this;
        if (!(-1 < this._config.disabledOptions.indexOf(e))) {
          if (e && !n && (this._config.value = this._config.multiple ? [].concat(l(this._config.value || []), [e]) : e), e && n && (this._config.value = e), this._options.forEach(function(e) {
              e.removeClass(i._config.classNames.selectedOption)
            }), this._placeholder.removeClass(this._config.classNames.placeholderHidden), this._config.multiple) {
            var s = this._config.value.map(function(t) {
              var n = i._config.options.find(function(e) {
                return e.value === t
              });
              return i._options.find(function(e) {
                return e.get().getAttribute("data-value") === n.value.toString()
              }).addClass(i._config.classNames.selectedOption), n
            });
            return s.length && this._placeholder.addClass(this._config.classNames.placeholderHidden), void this._selectOptions(s, t)
          }
          var o = this._config.value ? this._config.options.find(function(e) {
              return e.value.toString() === i._config.value
            }) : this._config.options[0],
            a = this._options.find(function(e) {
              return e.get().getAttribute("data-value") === o.value.toString()
            });
          this._config.value ? (a.addClass(this._config.classNames.selectedOption), this._placeholder.addClass(this._config.classNames.placeholderHidden), this._selectOption(o, t)) : this._label.setText("")
        }
      }
    }, {
      key: "_selectOption",
      value: function(e, t) {
        this._selectedOption = e, this._label.setText(e.label), this._config.onChange && t && this._config.onChange(e.value)
      }
    }, {
      key: "_selectOptions",
      value: function(e, t) {
        var i = this;
        this._label.setText(""), this._icons = e.map(function(e) {
          var t = new c("span", {
              class: i._config.classNames.selectedLabel,
              textContent: e.label
            }),
            n = new c(i._config.inlineIcon ? i._config.inlineIcon.cloneNode(!0) : "i", {
              class: i._config.icon,
              value: e.value
            });
          return n.addEventListener("click", i._boundUnselectOption), t.append(n.get()), i._label.append(t.get()), n.get()
        }), t && this._optionsWrapper.setBottom(Number(this._select.getHeight().split("px")[0]) + 5), this._config.onChange && t && this._config.onChange(this._config.value)
      }
    }, {
      key: "_unselectOption",
      value: function(e) {
        var t = l(this._config.value),
          n = t.indexOf(e.target.getAttribute("data-value")); - 1 !== n && t.splice(n, 1), this._setValue(t, !0, !0)
      }
    }, {
      key: "_sortOptions",
      value: function(t) {
        var n = this;
        this._options.forEach(function(e) {
          e.get().textContent.toLowerCase().startsWith(t.target.value.toLowerCase()) ? e.removeClass(n._config.classNames.optionHidden) : e.addClass(n._config.classNames.optionHidden)
        })
      }
    }]), n
  }()
}();
