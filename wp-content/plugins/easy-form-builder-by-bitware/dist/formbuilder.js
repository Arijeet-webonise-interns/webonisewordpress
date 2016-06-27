(function() {
  rivets.binders.input = {
    publishes: true,
    routine: rivets.binders.value.routine,
    bind: function(el) {
      return $(el).bind('input.rivets', this.publish);
    },
    unbind: function(el) {
      return $(el).unbind('input.rivets');
    }
  };

  rivets.configure({
    prefix: "rv",
    adapter: {
      subscribe: function(obj, keypath, callback) {
        callback.wrapped = function(m, v) {
          return callback(v);
        };
        return obj.on('change:' + keypath, callback.wrapped);
      },
      unsubscribe: function(obj, keypath, callback) {
        return obj.off('change:' + keypath, callback.wrapped);
      },
      read: function(obj, keypath) {
        if (keypath === "cid") {
          return obj.cid;
        }
        return obj.get(keypath);
      },
      publish: function(obj, keypath, value) {
        if (obj.cid) {
          return obj.set(keypath, value);
        } else {
          return obj[keypath] = value;
        }
      }
    }
  });

}).call(this);

(function() {
  var BuilderView, EditFieldView, Formbuilder, FormbuilderCollection, FormbuilderModel, ViewFieldView, _ref, _ref1, _ref2, _ref3, _ref4,
    __hasProp = {}.hasOwnProperty,
    __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

  FormbuilderModel = (function(_super) {
    __extends(FormbuilderModel, _super);

    function FormbuilderModel() {
      _ref = FormbuilderModel.__super__.constructor.apply(this, arguments);
      return _ref;
    }

    FormbuilderModel.prototype.sync = function() {};

    FormbuilderModel.prototype.indexInDOM = function() {
      var $wrapper,
        _this = this;
      $wrapper = $(".fb-field-wrapper").filter((function(_, el) {
        return $(el).data('cid') === _this.cid;
      }));
      return $(".fb-field-wrapper").index($wrapper);
    };

    FormbuilderModel.prototype.is_input = function() {
      return Formbuilder.inputFields[this.get(Formbuilder.options.mappings.FIELD_TYPE)] != null;
    };

    return FormbuilderModel;

  })(Backbone.DeepModel);

  FormbuilderCollection = (function(_super) {
    __extends(FormbuilderCollection, _super);

    function FormbuilderCollection() {
      _ref1 = FormbuilderCollection.__super__.constructor.apply(this, arguments);
      return _ref1;
    }

    FormbuilderCollection.prototype.initialize = function() {
      return this.on('add', this.copyCidToModel);
    };

    FormbuilderCollection.prototype.model = FormbuilderModel;

    FormbuilderCollection.prototype.comparator = function(model) {
      return model.indexInDOM();
    };

    FormbuilderCollection.prototype.copyCidToModel = function(model) {
      return model.attributes.cid = model.cid;
    };

    return FormbuilderCollection;

  })(Backbone.Collection);

  ViewFieldView = (function(_super) {
    __extends(ViewFieldView, _super);

    function ViewFieldView() {
      _ref2 = ViewFieldView.__super__.constructor.apply(this, arguments);
      return _ref2;
    }

    ViewFieldView.prototype.className = "fb-field-wrapper";

    ViewFieldView.prototype.events = {
      'click .subtemplate-wrapper': 'focusEditView',
      'click .js-duplicate': 'duplicate',
      'click .js-clear': 'clear'
    };

    ViewFieldView.prototype.initialize = function(options) {
      this.parentView = options.parentView;
      this.listenTo(this.model, "change", this.render);
      return this.listenTo(this.model, "destroy", this.remove);
    };

    ViewFieldView.prototype.render = function() {
      this.$el.addClass('response-field-' + this.model.get(Formbuilder.options.mappings.FIELD_TYPE)).data('cid', this.model.cid).html(Formbuilder.templates["view/base" + (!this.model.is_input() ? '_non_input' : '')]({
        rf: this.model
      }));
    
  this.$el.attr('id',this.model.cid).siblings('.response-field'+ this.model.get(Formbuilder.options.mappings.FIELD_TYPE));
  
      return this;
    };

    ViewFieldView.prototype.focusEditView = function() {
      return this.parentView.createAndShowEditView(this.model);
    };

    ViewFieldView.prototype.clear = function(e) {
      var cb, x,
        _this = this;
      e.preventDefault();
      e.stopPropagation();
      cb = function() {
        _this.parentView.handleFormUpdate();
        return _this.model.destroy();
      };
      x = Formbuilder.options.CLEAR_FIELD_CONFIRM;
      switch (typeof x) {
        case 'string':
          if (confirm(x)) {
            return cb();
          }
          break;
        case 'function':
          return x(cb);
        default:
          return cb();
      }
    };

    ViewFieldView.prototype.duplicate = function() {
      var attrs;
      attrs = _.clone(this.model.attributes);
      delete attrs['id'];
      attrs['label'] += ' Copy';
      return this.parentView.createField(attrs, {
        position: this.model.indexInDOM() + 1
      });
    };

    return ViewFieldView;

  })(Backbone.View);

  EditFieldView = (function(_super) {
    __extends(EditFieldView, _super);

    function EditFieldView() {
      _ref3 = EditFieldView.__super__.constructor.apply(this, arguments);
      return _ref3;
    }

    EditFieldView.prototype.className = "edit-response-field";

    EditFieldView.prototype.events = {
      'click .js-add-option': 'addOption',
      'click .js-remove-option': 'removeOption',
      'click .js-default-updated': 'defaultUpdated',
      'input .option-label-input': 'forceRender'
    };

    EditFieldView.prototype.initialize = function(options) {
    
      this.parentView = options.parentView;
      return this.listenTo(this.model, "destroy", this.remove);
    };

    EditFieldView.prototype.render = function() {
      this.$el.html(Formbuilder.templates["edit/base" + (!this.model.is_input() ? '_non_input' : '')]({
        rf: this.model
      }));
      rivets.bind(this.$el, {
        model: this.model
      });
      return this;
    };

    EditFieldView.prototype.remove = function() {
      this.parentView.editView = void 0;
      this.parentView.$el.find("[data-target=\"#addField\"]").click();
      return EditFieldView.__super__.remove.apply(this, arguments);
    };

    EditFieldView.prototype.addOption = function(e) {
      var $el, i, newOption, options;
      $el = $(e.currentTarget);
      i = this.$el.find('.option').index($el.closest('.option'));
      options = this.model.get(Formbuilder.options.mappings.OPTIONS) || [];
      newOption = {
        label: "",
        checked: false
      };
      if (i > -1) {
        options.splice(i + 1, 0, newOption);
      } else {
        options.push(newOption);
      }

      this.model.set(Formbuilder.options.mappings.OPTIONS, options);
      this.model.trigger("change:" + Formbuilder.options.mappings.OPTIONS);
      return this.forceRender();
    };

    EditFieldView.prototype.removeOption = function(e) {
      var $el, index, options;
      $el = $(e.currentTarget);
      index = this.$el.find(".js-remove-option").index($el);
      options = this.model.get(Formbuilder.options.mappings.OPTIONS);
      options.splice(index, 1);
      this.model.set(Formbuilder.options.mappings.OPTIONS, options);
      this.model.trigger("change:" + Formbuilder.options.mappings.OPTIONS);
      return this.forceRender();
    };

    EditFieldView.prototype.defaultUpdated = function(e) {
      var $el;
      $el = $(e.currentTarget);
      if (this.model.get(Formbuilder.options.mappings.FIELD_TYPE) !== 'checkboxes') {
        this.$el.find(".js-default-updated").not($el).attr('checked', false).trigger('change');
      }
      return this.forceRender();
    };

    EditFieldView.prototype.forceRender = function() {
      return this.model.trigger('change');
    };

    return EditFieldView;

  })(Backbone.View);

  BuilderView = (function(_super) {
    __extends(BuilderView, _super);

    function BuilderView() {
      _ref4 = BuilderView.__super__.constructor.apply(this, arguments);
      return _ref4;
    }

    BuilderView.prototype.SUBVIEWS = [];

    BuilderView.prototype.events = {
      'click .js-save-form': 'saveForm',
      'click .fb-tabs a': 'showTab',
      'click .fb-add-field-types a': 'addField',
      'mouseover .fb-add-field-types': 'lockLeftWrapper',
      'mouseout .fb-add-field-types': 'unlockLeftWrapper'
    };

    BuilderView.prototype.initialize = function(options) {
      var selector;
      selector = options.selector, this.formBuilder = options.formBuilder, this.bootstrapData = options.bootstrapData;
      if (selector != null) {
        this.setElement($(selector));
      }
      this.collection = new FormbuilderCollection;
      this.collection.bind('add', this.addOne, this);
      this.collection.bind('reset', this.reset, this);
      this.collection.bind('change', this.handleFormUpdate, this);
      this.collection.bind('destroy add reset', this.hideShowNoResponseFields, this);
      this.collection.bind('destroy', this.ensureEditViewScrolled, this);
      this.render();
      this.collection.reset(this.bootstrapData);
      return this.bindSaveEvent();
    };

    BuilderView.prototype.bindSaveEvent = function() {
      var _this = this;
      this.formSaved = true;
      this.saveFormButton = this.$el.find(".js-save-form");
      this.saveFormButton.attr('disabled', true).text(Formbuilder.options.dict.ALL_CHANGES_SAVED);
      if (!!Formbuilder.options.AUTOSAVE) {
        setInterval(function() {
          return _this.saveForm.call(_this);
        }, 5000);
      }
      return $(window).bind('beforeunload', function() {
        if (_this.formSaved) {
          return void 0;
        } else {
          return Formbuilder.options.dict.UNSAVED_CHANGES;
        }
      });
    };

    BuilderView.prototype.reset = function() {
      this.$responseFields.html('');
      return this.addAll();
    };

    BuilderView.prototype.render = function() {
      var subview, _i, _len, _ref5;
      this.$el.html(Formbuilder.templates['page']());
      this.$fbLeft = this.$el.find('.fb-left');
      this.$responseFields = this.$el.find('.fb-response-fields');
      this.bindWindowScrollEvent();
      this.hideShowNoResponseFields();
      _ref5 = this.SUBVIEWS;
      for (_i = 0, _len = _ref5.length; _i < _len; _i++) {
        subview = _ref5[_i];
        new subview({
          parentView: this
        }).render();
      }
      return this;
    };

    BuilderView.prototype.bindWindowScrollEvent = function() {
      var _this = this;
      return $(window).on('scroll', function() {
        var maxMargin, newMargin;
        if (_this.$fbLeft.data('locked') === true) {
          return;
        }
        newMargin = Math.max(0, $(window).scrollTop() - _this.$el.offset().top);
        maxMargin = _this.$responseFields.height();
        return _this.$fbLeft.css({
          'margin-top': Math.min(maxMargin, newMargin)
        });
      });
    };

    BuilderView.prototype.showTab = function(e) {
  
      var $el, first_model, target;
      $el = $(e.currentTarget);
      target = $el.data('target');

    $el.closest('li').addClass('active').siblings('li').removeClass('active');
      $(target).addClass('active').siblings('.fb-tab-pane').removeClass('active');
      if (target !== '#editField') {
        this.unlockLeftWrapper();
      }
      if (target === '#editField' && !this.editView && (first_model = this.collection.models[0])) {
        return this.createAndShowEditView(first_model);
      }
    };

    BuilderView.prototype.addOne = function(responseField, _, options) {
      var $replacePosition, view;
      view = new ViewFieldView({
        model: responseField,
        parentView: this
      });
      if (options.$replaceEl != null) {
        return options.$replaceEl.replaceWith(view.render().el);
      } else if ((options.position == null) || options.position === -1) {
        return this.$responseFields.append(view.render().el);
      } else if (options.position === 0) {
        return this.$responseFields.prepend(view.render().el);
      } else if (($replacePosition = this.$responseFields.find(".fb-field-wrapper").eq(options.position))[0]) {
        return $replacePosition.before(view.render().el);
      } else {
        return this.$responseFields.append(view.render().el);
      }
    };

    BuilderView.prototype.setSortable = function() {
      var _this = this;
      if (this.$responseFields.hasClass('ui-sortable')) {
        this.$responseFields.sortable('destroy');
      }
      this.$responseFields.sortable({
        forcePlaceholderSize: true,
        placeholder: 'sortable-placeholder',
        stop: function(e, ui) {
          var rf;
          if (ui.item.data('field-type')) {
            rf = _this.collection.create(Formbuilder.helpers.defaultFieldAttrs(ui.item.data('field-type')), {
              $replaceEl: ui.item
            });
            _this.createAndShowEditView(rf);
          }
          _this.handleFormUpdate();
          return true;
        },
        update: function(e, ui) {
          if (!ui.item.data('field-type')) {
            return _this.ensureEditViewScrolled();
          }
        }
      });
      return this.setDraggable();
    };

    BuilderView.prototype.setDraggable = function() {
      var $addFieldButtons,
        _this = this;
      $addFieldButtons = this.$el.find("[data-field-type]");
      return $addFieldButtons.draggable({
        connectToSortable: this.$responseFields,
        helper: function() {
          var $helper;
          $helper = $("<div class='response-field-draggable-helper' />");
          $helper.css({
            width: _this.$responseFields.width(),
            height: '80px'
          });
          return $helper;
        }
      });
    };

    BuilderView.prototype.addAll = function() {
      this.collection.each(this.addOne, this);
      return this.setSortable();
    };

    BuilderView.prototype.hideShowNoResponseFields = function() {
      return this.$el.find(".fb-no-response-fields")[this.collection.length > 0 ? 'hide' : 'show']();
    };

    BuilderView.prototype.addField = function(e) {
      var field_type,elementid;
      field_type = $(e.currentTarget).data('field-type');
    //elementid= $(e.currentTarget).data('cid');
      return this.createField(Formbuilder.helpers.defaultFieldAttrs(field_type));
    };

    BuilderView.prototype.createField = function(attrs, options) {
      var rf;
      rf = this.collection.create(attrs, options);
      this.createAndShowEditView(rf);
      return this.handleFormUpdate();
    };

    BuilderView.prototype.createAndShowEditView = function(model) {
  
      var $newEditEl, $responseFieldEl;

    $responseFieldEl = this.$el.find(".fb-field-wrapper").filter(function() {
       return $(this).data('cid') === model.cid;
      });
    
    console.log('cid:'+model.cid);
     $responseFieldEl.addClass('editing').siblings('.fb-field-wrapper').removeClass('editing');
   //$responseFieldEl.attr('id',model.cid).siblings('.fb-field-wrapper');
      if (this.editView) {
        if (this.editView.model.cid === model.cid) {
          this.$el.find(".fb-tabs a[data-target=\"#editField\"]").click();
      this.scrollLeftWrapper($responseFieldEl);
          return;
        }
        this.editView.remove();
      }
    
      this.editView = new EditFieldView({
        model: model,
        parentView: this
      });
      $newEditEl = this.editView.render().$el;
      this.$el.find(".fb-edit-field-wrapper").html($newEditEl);
      this.$el.find(".fb-tabs a[data-target=\"#editField\"]").click();
      this.scrollLeftWrapper($responseFieldEl);

      return this;
    };
  
   
    BuilderView.prototype.ensureEditViewScrolled = function() {
      if (!this.editView) {
        return;
      }
      return this.scrollLeftWrapper($(".fb-field-wrapper.editing"));
    };

    BuilderView.prototype.scrollLeftWrapper = function($responseFieldEl) {
      var _this = this;
      this.unlockLeftWrapper();
      if (!$responseFieldEl[0]) {
        return;
      }
      return $.scrollWindowTo((this.$el.offset().top + $responseFieldEl.offset().top) - this.$responseFields.offset().top, 200, function() {
        return _this.lockLeftWrapper();
      });
    };

    BuilderView.prototype.lockLeftWrapper = function() {
      return this.$fbLeft.data('locked', true);
    };

    BuilderView.prototype.unlockLeftWrapper = function() {
      return this.$fbLeft.data('locked', false);
    };

    BuilderView.prototype.handleFormUpdate = function() {
      if (this.updatingBatch) {
        return;
      }
      this.formSaved = false;
      return this.saveFormButton.removeAttr('disabled').text(Formbuilder.options.dict.SAVE_FORM);
    };

    BuilderView.prototype.saveForm = function(e) {
      var payload;
      if (this.formSaved) {
        return;
      }
      this.formSaved = true;
      this.saveFormButton.attr('disabled', true).text(Formbuilder.options.dict.ALL_CHANGES_SAVED);
      this.collection.sort();
      payload = JSON.stringify({
        fields: this.collection.toJSON()
      });
      if (Formbuilder.options.HTTP_ENDPOINT) {
        this.doAjaxSave(payload);
      }
      return this.formBuilder.trigger('save', payload);
    };

    BuilderView.prototype.doAjaxSave = function(payload) {
      var _this = this;
      return $.ajax({
        url: Formbuilder.options.HTTP_ENDPOINT,
        type: Formbuilder.options.HTTP_METHOD,
        data: payload,
        contentType: "application/json",
        success: function(data) {
          var datum, _i, _len, _ref5;
          _this.updatingBatch = true;
          for (_i = 0, _len = data.length; _i < _len; _i++) {
            datum = data[_i];
            if ((_ref5 = _this.collection.get(datum.cid)) != null) {
              _ref5.set({
                id: datum.id
              });
            }
            _this.collection.trigger('sync');
          }
          return _this.updatingBatch = void 0;
        }
      });
    };

    return BuilderView;

  })(Backbone.View);

  Formbuilder = (function() {
    Formbuilder.helpers = {
      defaultFieldAttrs: function(field_type) {
        var attrs, _base;
        attrs = {};
    
    //attrs[Formbuilder.options.mappings.ELEMENT_ID] = elementid;
    attrs[Formbuilder.options.mappings.FIELD_TYPE] = field_type;
    
    if(field_type=="Toggle")
    {
        attrs[Formbuilder.options.mappings.LABEL] ="";//'Untitled';
        attrs[Formbuilder.options.mappings.REQUIRED] = false;
    }
     else
    {
      attrs[Formbuilder.options.mappings.LABEL] = field_type.toUpperCase();//'Untitled';
        attrs[Formbuilder.options.mappings.REQUIRED] = true;
		  attrs[Formbuilder.options.mappings.READ_ONLY] = false;
    }    
        attrs['field_options'] = {};
        return (typeof (_base = Formbuilder.fields[field_type]).defaultAttributes === "function" ? _base.defaultAttributes(attrs) : void 0) || attrs;
      },
      simple_format: function(x) {
        return x != null ? x.replace(/\n/g, '<br />') : void 0;
      }
    };

    Formbuilder.options = {
      //DEFAULT_TOGGLE: 'field_options.togglelabel',
      BUTTON_CLASS: 'fb-button',
      HTTP_ENDPOINT: '',
      HTTP_METHOD: 'POST',
      AUTOSAVE: true,
      CLEAR_FIELD_CONFIRM: false,
      mappings: {
     SELECTED_NAME:'Normal',
     SELECTED_ADDRESS:'Checked',
     ADDRESS_USRESTRICT:'field_options.usrestrict',
	 CAPCHA_TEXT:'field_options.capcha_text',
     ADDRESS:'field_options.address',
     NAME:'field_options.name',   
   CURRENCY_SLIDER:'field_options.currencyslider',
     DEFAULT_VALUE_FIRST_NM:'firstnm',
     DEFAULT_VALUE_LAST_NM:'lastnm',
  // Date variable
     DEFAULT_VALUE_DATE:'field_options.defaultval_date',
	 SITE_KEY:'field_options.site_key',
	 SECREAT_KEY:'field_options.secreat_key',
     DEFAULT_VALUE_MINDATE:'field_options.defaultminval_date',
     DEFAULT_VALUE_MAXDATE:'field_options.defaultmaxval_date',
     DATE_FX_REL:'field_options.datefixedrelative',
     SELECTED_DATE:'date1',
      DATE:'field_options.date',
      DATE_DD:'',
      DATE_MM:'',
      DATE_YYYY:'',
      DATE_VALUE_FIX_MIN: 'field_options.datevalfixmin',
      DATE_VALUE_FIX_MAX: 'field_options.datevalfixmax',
      DATE_VALUE_REL_MIN: 'field_options.datevalRelmin',
      DATE_VALUE_REL_MAX: 'field_options.datevalRelmax',
      DATE_EN_SELECTION_LIMIT: 'field_options.EnDtSelLimit',
      ENABLEMINMAXDATE: 'field_options.ENABLEMINMAXDATE',
      ENABLEDATELIMIT: 'field_options.ENABLEDATELIMIT',
      DISABLEPASTFURDATE: 'field_options.DISABLEPASTFURDATE',
      ALLPASTFURDATE: 'field_options.ALLPASTFURDATE',
      DISABLEWEEKENDDATE: 'field_options.DISABLEWEEKENDDATE',
      DISABLESPCDATE: 'field_options.DISABLESPCDATE',
      DISABLESPCDATETXTAREA: 'field_options.DISABLESPCDATETXTAREA',
//End Date variable 
    CHECKBOX: 'field_options.checkbox', //checkbox
    RADIO: 'field_options.radio',  //radio
//Currency
 CURRENCY:'field_options.currency',
    /* file upload*/
    LIMIT_FILE_UP_TXTAR: 'field_options.LIMIT_FILE_UP_TXTAR',
    LIMIT_MUL_FILE_UP: 'field_options.LIMIT_MUL_FILE_UP',
    LIMIT_MAX_FILEUP_SIZE: 'field_options.LIMIT_MAX_FILEUP_SIZE',
    AUTO_UP_FILE: 'field_options.AUTO_UP_FILE',
    MUL_FILE_UP: 'field_options.MUL_FILE_UP',
    LIMIT_FILE_SIZE: 'field_options.LIMIT_FILE_SIZE',
    LIMIT_FIL_UPLOAD_TYPE: 'field_options.LIMIT_FIL_UPLOAD_TYPE',
    FILE_EMAIL_ATTACH: 'field_options.FILE_EMAIL_ATTACH',
    /*end*/    
    ELEMENT_ID:'elementid',
    SELECTED_TIME:'SecondField',
    TIME:'field_options.time',
    SELECTED_PHONE:'International',
    PHONE: 'field_options.phone',
    SELECTED_DATE:'date1',
    DATE:'field_options.date',
    DEFAULT_VAL_EMAIL:'field.options.defaultValEmail',
    DEFAULT_VALUE_PHONE:'field_options.defaultvaluephone',  
    DEFAULT_VALUE_PHONE_INTERNATIONAL1:'field_options.defaultvaluephone1',  
    DEFAULT_VALUE_PHONE_INTERNATIONAL2:'field_options.defaultvaluephone2',  
    DEFAULT_VALUE_PHONE_INTERNATIONAL3:'field_options.defaultvaluephone3',  
    DEFAULT_VALUE_TEXTAREA:'field_options.defaultvaluetextarea',  
    CUSTOM_CSS_CLASS: 'field_options.customcssclass', 
    VISIBILITY: 'field_options.visibility',
    PASSWORD: 'field_options.password',
    DEFAULT_VALUE: 'field_options.defaultvalue',
    DEFAULT_COUNTRY:'field_options.defaultcountry',
    URL_TEXT:'field_options.urltext',
    DEFAULT_URL:'field_options.defaulturl',
    SIZE: 'field_options.size',
	READ_ONLY:'field_options.READONLY',
	UNITS: 'field_options.units',
	LABEL: 'label',
	FIELD_TYPE: 'field_type',
	REQUIRED: 'required',
	ADMIN_ONLY: 'admin_only',
	OPTIONS: 'field_options.options',
	DESCRIPTION: 'field_options.description',
	INCLUDE_OTHER: 'field_options.include_other_option',
	INCLUDE_BLANK: 'field_options.include_blank_option',
	INTEGER_ONLY: 'field_options.integer_only',
	MIN: 'field_options.min',
	MAX: 'field_options.max',
	MINLENGTH: 'field_options.minlength',
	MAXLENGTH: 'field_options.maxlength',
	LENGTH_UNITS: 'field_options.min_max_length_units'
      },
      dict: {
        ALL_CHANGES_SAVED: 'All changes saved',
        SAVE_FORM: 'Saving form',
        UNSAVED_CHANGES: 'You have unsaved changes. If you leave this page, you will lose those changes!'
      }
    };

    Formbuilder.fields = {};

    Formbuilder.inputFields = {};

    Formbuilder.nonInputFields = {};

    Formbuilder.registerField = function(name, opts) {
      var x, _i, _len, _ref5;
      _ref5 = ['view', 'edit'];
      for (_i = 0, _len = _ref5.length; _i < _len; _i++) {
        x = _ref5[_i];
        opts[x] = _.template(opts[x]);
    
      }
      opts.field_type = name;
      Formbuilder.fields[name] = opts;
      if (opts.type === 'non_input') {
        return Formbuilder.nonInputFields[name] = opts;
      } else {
        return Formbuilder.inputFields[name] = opts;
      }
    };

    function Formbuilder(opts) {
      var args;
      if (opts == null) {
        opts = {};
      }
      _.extend(this, Backbone.Events);
      args = _.extend(opts, {
        formBuilder: this
      });
      this.mainView = new BuilderView(args);
    }

    return Formbuilder;

  })();

  window.Formbuilder = Formbuilder;

  if (typeof module !== "undefined" && module !== null) {
    module.exports = Formbuilder;
  } else {
    window.Formbuilder = Formbuilder;
  }

}).call(this);

/*
rf.get(Formbuilder.options.mappings.REQUIRED)
*/
(function() {
  Formbuilder.registerField('address', {
    order: 11,
    view: "<div class='elementdiv <%= rf.get(Formbuilder.options.mappings.VISIBILITY) %>  <%= rf.get(Formbuilder.options.mappings.CUSTOM_CSS_CLASS) %> '>  <div class='input-line'>\n  <span class='street'>\n <label>Address line 1</label> \n <input type='text' <%= rf.get(Formbuilder.options.mappings.VISIBILITY) %>/>\n  </span>\n</div><% if(Formbuilder.options.mappings.SELECTED_ADDRESS=='checked'){%><div class='input-line'>\n  <span class='street'>\n <label>Address line 2</label>\n <input type='text' <%= rf.get(Formbuilder.options.mappings.VISIBILITY) %>/>\n   </span>\n</div><%}%>\n\n<div class='input-line'>\n  <span class='city'>\n  <label>City</label>\n  <input type='text' <%= rf.get(Formbuilder.options.mappings.VISIBILITY) %> />\n   </span>\n\n  <span class='state'>\n  <label>State / Province / Region</label>\n   <input type='text' <%= rf.get(Formbuilder.options.mappings.VISIBILITY) %>/>\n  </span>\n</div>\n\n<div class='input-line'>\n  <span class='zip'>\n   \n    <label>Zipcode</label> <input type='text'<%= rf.get(Formbuilder.options.mappings.VISIBILITY) %> />\n  </span>\n\n  <span class='country'>\n <label>Country</label> \n<select class=\"form-control\"><option><% if(rf.get(Formbuilder.options.mappings.ADDRESS_USRESTRICT)==true){ %> United States</option> <% }else{ %> <%=  rf.get(Formbuilder.options.mappings.DEFAULT_COUNTRY) %> </option> <%} %></select> \n  </span>\n</div></div>",
    edit: "  <%= Formbuilder.templates['edit/READONLY']() %><label id=\"readonlyid\">Read only</label> <%= Formbuilder.templates['edit/visibility']() %><%= Formbuilder.templates['edit/address']() %> \n <%= Formbuilder.templates['edit/setusrestrcted']() %> \n<%= Formbuilder.templates['edit/defaultcountry']() %>\n \n <%= Formbuilder.templates['edit/customcssclass']() %>\n<br>",
    addButton: "<span class=\"symbol\"><span style = \"align:left;\"class=\"fa fa-home\"></span></span> Address",
  
  defaultAttributes: function(attrs) {     
    attrs.field_options.visibility = 'visible';
    attrs.field_options.address= 'unchecked';   
    return attrs;
    }
  });

}).call(this);

// Captcha

(function() {
  Formbuilder.registerField('Captcha', {
    order: 91,
    view: "<div class='elementdiv <%= rf.get(Formbuilder.options.mappings.CUSTOM_CSS_CLASS) %>'/> <input  type=' <%= rf.get(Formbuilder.options.mappings.CAPCHA_TEXT) %>' style=\"display:none\" /></div>",
    edit: "<%= Formbuilder.templates['edit/site_key']() %><%= Formbuilder.templates['edit/secreat_key']() %><%= Formbuilder.templates['edit/customcssclass']() %>",
    addButton: "<span class='symbol'><span class='fa fa-clone'></span></span> Captcha",
  });

}).call(this);

(function() {
  Formbuilder.registerField('checkboxes', {
    order: 4,
    view: "<% for (i in (rf.get(Formbuilder.options.mappings.OPTIONS) || [])) { %>\n  <div>\n    <label class='fb-option <%= rf.get(Formbuilder.options.mappings.VISIBILITY) %> <%= rf.get(Formbuilder.options.mappings.CUSTOM_CSS_CLASS) %> <%= rf.get(Formbuilder.options.mappings.CHECKBOX) %> '>\n      <input type='checkbox' <%= rf.get(Formbuilder.options.mappings.OPTIONS)[i].checked && 'checked' %>  onclick=\"javascript: return false;\" class=\'<%= rf.get(Formbuilder.options.mappings.CUSTOM_CSS_CLASS) %> <%= rf.get(Formbuilder.options.mappings.VISIBILITY) %>\'  />\n    <%= rf.get(Formbuilder.options.mappings.OPTIONS)[i].label %>\n    </label>\n  </div>\n<% } %>\n\n<% if (rf.get(Formbuilder.options.mappings.INCLUDE_OTHER)) { %>\n  <div class='other-option'>\n  <label class='fb-option'>\n   <input type='checkbox' />\n   Other\n   </label>\n\n    <input type='text' />\n  </div>\n<% } %>",
    edit: "<%= Formbuilder.templates['edit/visibility']() %>\n<%= Formbuilder.templates['edit/checkbox']() %>\n<%= Formbuilder.templates['edit/options']({ includeOther: true }) %>\n <%= Formbuilder.templates['edit/customcssclass']() %> ",
    addButton: "<span class=\"symbol\"><span class=\"fa fa-check-square-o\"></span></span> Checkboxes",
    defaultAttributes: function(attrs) {
      attrs.field_options.options = [
        {
          label: "Option1",
          checked: false
        }, {
          label: "Option2",
          checked: false
        }
      ];
    attrs.field_options.visibility = 'visible';
    attrs.field_options.checkbox = 'one_column';
      return attrs;
    }
  });

}).call(this);

(function() {
  Formbuilder.registerField('date', {
    order: 8,
    view: "<% if(typeof rf.get(Formbuilder.options.mappings.DEFAULT_VALUE_DATE) != 'undefined'){var str=rf.get(Formbuilder.options.mappings.DEFAULT_VALUE_DATE);    var dateObj = new Date(str);var month = dateObj.getUTCMonth() + 1;var day = dateObj.getUTCDate()+1;var year = dateObj.getUTCFullYear();Formbuilder.options.mappings.DATE_DD=day;Formbuilder.options.mappings.DATE_MM=month;Formbuilder.options.mappings.DATE_YYYY=year; }else{} if(Formbuilder.options.mappings.SELECTED_DATE=='date1'){ %>  <div class='input-line  <%= rf.get(Formbuilder.options.mappings.CUSTOM_CSS_CLASS) %> <%= rf.get(Formbuilder.options.mappings.VISIBILITY) %>' >\n  <span class='month'>\n<input  type='text' value='<%=month%>'/>\n    <label>MM</label>\n  </span>\n\n  <span class='above-line'>/</span>\n\n  <span class='day'>\n    <input type=\"text\"  value='<%=day%>'/>\n    <label>DD</label>\n  </span>\n\n  <span class='above-line'>/</span>\n\n  <span class='year'>\n    <input type=\"text\" style=\"width:60px;\" value='<%=year%>' />\n    <label>YYYY</label>\n </span>\n</div> <% }  else {%> <div class='input-line <%= rf.get(Formbuilder.options.mappings.CUSTOM_CSS_CLASS) %> <%= rf.get(Formbuilder.options.mappings.VISIBILITY) %>' >\n  <span class='month'>\n<input type=\"text\" value='<%=day%>' />\n    <label>DD</label>\n  </span>\n\n  <span class='above-line'>/</span>\n\n  <span class='day'>\n    <input type=\"text\" value='<%=month%>'/>\n    <label>MM</label>\n  </span>\n\n  <span class='above-line'>/</span>\n\n  <span class='year'>\n <input type=\"text\" value='<%=year%>' />\n<label>YYYY</label>\n </span>\n</div> <%}%> ",
    edit: " <%= Formbuilder.templates['edit/READONLY']() %><label id=\"readonlyid\">Read only</label><%= Formbuilder.templates['edit/visibility']() %>\n<%= Formbuilder.templates['edit/defaultval_date']() %>\n <%= Formbuilder.templates['edit/dateformat']() %><br>\n<span><%= Formbuilder.templates['edit/ENABLEMINMAXDATE']() %><label for='prop_date_range' class='choice'>Enable Minimum and/or Maximum Dates</label><div <%  if(typeof rf.get(Formbuilder.options.mappings.ENABLEMINMAXDATE) != 'undefined'){ if(rf.get(Formbuilder.options.mappings.ENABLEMINMAXDATE)==false || rf.get(Formbuilder.options.mappings.DISABLEPASTFURDATE)==true ){%>style='display: none;'<%} else{%>style='display: block;' <%}}else{%>style='display: none;'<%}%> id='prop_date_range_details'><div style='margin-left: 23px;margin-top: 10px'><%= Formbuilder.templates['edit/datefixedrelative']() %></div><div id='prop_date_range_fixed' style='display: block;'><%= Formbuilder.templates['edit/datevalfixmin']() %>\n<%= Formbuilder.templates['edit/datevalfixmax']() %>\n </div> <div style='display: none;' id='prop_date_range_relative'> <%= Formbuilder.templates['edit/datevalRelmin']() %>\n<%= Formbuilder.templates['edit/datevalRelmax']() %>\n </div><div style='clear: both'></div></div><div style='clear: both'></div> <%= Formbuilder.templates['edit/ENABLEDATELIMIT']() %><label for='prop_date_selection_limit' class='choice'>Enable Date Selection Limit</label><div <%  if(typeof rf.get(Formbuilder.options.mappings.ENABLEDATELIMIT) != 'undefined'){ if(rf.get(Formbuilder.options.mappings.ENABLEDATELIMIT)==false){%>style='display: none;'<%} else{%>style='display: block;' <%}}else{%>style='display: none;'<%}%> id='form_date_selection_limit'>Only allow each date to be selected<%= Formbuilder.templates['edit/EnDtSelLimit']() %>times</div><div style='clear: both'></div> <%= Formbuilder.templates['edit/DISABLEPASTFURDATE']() %><label for='prop_date_past_future_selection' class='choice'>Disable</label><%= Formbuilder.templates['edit/ALLPASTFURDATE']() %><div style='clear: both'></div><%= Formbuilder.templates['edit/DISABLEWEEKENDDATE']() %><label for='prop_date_disable_weekend' class='choice'>Disable Weekend Dates</label><div style='clear: both'></div><%= Formbuilder.templates['edit/DISABLESPCDATE']() %><label for='prop_date_disable_specific' class='choice'>Disable Specific Dates</label><div  style='display: block;' id='form_date_disable_specific'><%= Formbuilder.templates['edit/DISABLESPCDATETXTAREA']() %><div style='display: none'></div></div></span> \n<%= Formbuilder.templates['edit/customcssclass']() %>",
    addButton: "<span class=\"symbol\"><span class=\"fa fa-calendar\"></span></span> Date",
  defaultAttributes: function(attrs) {
      attrs.field_options.date = 'date1';
      attrs.field_options.datefixedrelative = 'fixed';
      attrs.field_options.ALLPASTFURDATE = 'past';
      attrs.field_options.visibility = 'visible';
    return attrs;
    }
  });

}).call(this);

(function() {
  Formbuilder.registerField('dropdown', {
    order: 6,
    view: "<select class=\"rf-size-<%= rf.get(Formbuilder.options.mappings.SIZE) %> <%= rf.get(Formbuilder.options.mappings.CUSTOM_CSS_CLASS) %> <%= rf.get(Formbuilder.options.mappings.VISIBILITY) %>\"  style=\"font-size:15px !important;\">\n  <% if (rf.get(Formbuilder.options.mappings.INCLUDE_BLANK)) { %>\n    <option value=''></option>\n  <% } %>\n\n  <% for (i in (rf.get(Formbuilder.options.mappings.OPTIONS) || [])) { %>\n    <option <%= rf.get(Formbuilder.options.mappings.OPTIONS)[i].checked && 'selected' %>>\n      <%= rf.get(Formbuilder.options.mappings.OPTIONS)[i].label %>\n    </option>\n  <% } %>\n</select>",
    edit: " <%= Formbuilder.templates['edit/READONLY']() %><label id=\"readonlyid\">Read only</label><%= Formbuilder.templates['edit/visibility']() %>\n<%= Formbuilder.templates['edit/size']() %>\n <%= Formbuilder.templates['edit/options']({ includeBlank: true }) %>\n <%= Formbuilder.templates['edit/customcssclass']() %> ",
    addButton: "<span class=\"symbol\"><span class=\"fa fa-caret-down\"></span></span> Dropdown",
    defaultAttributes: function(attrs) {
      attrs.field_options.options = [
        {
          label: "",
          checked: false
        }, {
          label: "",
          checked: false
        }
      ];
    attrs.field_options.size = 'small';
    attrs.field_options.visibility = 'visible';
      attrs.field_options.include_blank_option = false;
      return attrs;
    }
  });

}).call(this);

(function() {
  Formbuilder.registerField('email', {
    order: 14,
    view: "<input type='text' class='rf-size-<%= rf.get(Formbuilder.options.mappings.SIZE) %>  <%= rf.get(Formbuilder.options.mappings.CUSTOM_CSS_CLASS) %><%= rf.get(Formbuilder.options.mappings.VISIBILITY) %><%= rf.get(Formbuilder.options.mappings.DEFAULT_VAL_EMAIL) %>'/>",
    edit: " <%= Formbuilder.templates['edit/READONLY']() %><label id=\"readonlyid\">Read only</label><%= Formbuilder.templates['edit/size']() %>\n <%= Formbuilder.templates['edit/visibility']() %>\n <%= Formbuilder.templates['edit/defaultValEmail']() %>\n <%= Formbuilder.templates['edit/customcssclass']() %>",
    addButton: "<span class=\"symbol\"><span class=\"fa fa-envelope-o\"></span></span> Email",
  defaultAttributes: function(attrs) {
         
     attrs.field_options.visibility = 'visible';
      return attrs;
    }
  });

}).call(this);

(function() {


}).call(this);

// In edit number \n<%= Formbuilder.templates['edit/integer_only']() %> 
(function() {
  Formbuilder.registerField('number', {
    order: 2,
    view: "<div class='elementdiv <%= rf.get(Formbuilder.options.mappings.VISIBILITY) %>  <%= rf.get(Formbuilder.options.mappings.CUSTOM_CSS_CLASS) %>'><input type='text' class='rf-size-<%= rf.get(Formbuilder.options.mappings.SIZE) %>  ' value='<%= rf.get(Formbuilder.options.mappings.DEFAULT_VALUE) %>' />\n	<% if (units = rf.get(Formbuilder.options.mappings.UNITS)) { %>\n  <%= units %>\n<% } %></div>",
    edit: " <%= Formbuilder.templates['edit/READONLY']() %><label id=\"readonlyid\">Read only</label><%= Formbuilder.templates['edit/size']() %>\n <%= Formbuilder.templates['edit/visibility']() %>\n <%= Formbuilder.templates['edit/min_max']() %>\n<%= Formbuilder.templates['edit/units']() %>\n <%= Formbuilder.templates['edit/defaultvalue']() %>\n <%= Formbuilder.templates['edit/customcssclass']() %> ",
    addButton: "<span class=\"symbol\"><span class=\"fa fa-number\">123</span></span> Number",
  defaultAttributes: function(attrs) {
      attrs.field_options.size = 'small';
    attrs.field_options.visibility = 'visible';
      return attrs;
    }
  });

}).call(this);

(function() {
  Formbuilder.registerField('paragraph', {
    order: 3,
    view: "<div class='elementdiv <%= rf.get(Formbuilder.options.mappings.VISIBILITY) %> <%= rf.get(Formbuilder.options.mappings.CUSTOM_CSS_CLASS) %>  '><textarea class='rf-size-<%= rf.get(Formbuilder.options.mappings.SIZE) %>'> <%= rf.get(Formbuilder.options.mappings.DEFAULT_VALUE_TEXTAREA) %> </textarea></div>",
    edit: " <%= Formbuilder.templates['edit/READONLY']() %><label id=\"readonlyid\">Read only</label><%= Formbuilder.templates['edit/size']() %>\n <%= Formbuilder.templates['edit/visibility']() %>\n<%= Formbuilder.templates['edit/min_max_length']() %>\n <%= Formbuilder.templates['edit/defaultvaluetextarea']() %>\n <%= Formbuilder.templates['edit/customcssclass']() %>",
    addButton: "<span class=\"fa fa-paragraph\"></span> Paragraph Text",
    defaultAttributes: function(attrs) {
      attrs.field_options.size = 'small';
      attrs.field_options.visibility = 'visible';
      attrs.field_options.min_max_length_units='characters';
      return attrs;
    }
  });
}).call(this);

(function() {
  Formbuilder.registerField('price', {
    order: 13,
    view: "<div class='elementdiv <%= rf.get(Formbuilder.options.mappings.VISIBILITY) %><%= rf.get(Formbuilder.options.mappings.CUSTOM_CSS_CLASS) %>'><div class='input-line'>\n  <span class='above-line'><%= EFBP_getCurrencySymbol(rf.get(Formbuilder.options.mappings.CURRENCY)) %></span>\n  <span class='dolars'>\n    <input type='text'  placeholder='<%= EFBP_getCurrencyFirst(rf.get(Formbuilder.options.mappings.CURRENCY)) %>'  <%= rf.get(Formbuilder.options.mappings.VISIBILITY) %>  />\n  </span>\n  <span class='above-line'>.</span>\n  <span class='cents'>\n    <input type='text' placeholder='<%= EFBP_getCurrencySecond(rf.get(Formbuilder.options.mappings.CURRENCY)) %>'  />\n  </span>\n</div></div>",
    edit: " <%= Formbuilder.templates['edit/READONLY']() %><label id=\"readonlyid\">Read only</label>\n <%= Formbuilder.templates['edit/customcssclass']() %>\n <%= Formbuilder.templates['edit/currency']() %>\n<%= Formbuilder.templates['edit/visibility']() %>\n",
    addButton: "<span class=\"symbol\"><span class=\"fa fa-usd\"></span></span> Price",
  defaultAttributes: function(attrs) {         
     attrs.field_options.visibility = 'visible';
    attrs.field_options.currency='dollar';
    
      return attrs;
    }
  });

}).call(this);


(function() {
  Formbuilder.registerField('radio', {
    order: 5,
    view: "<% for (i in (rf.get(Formbuilder.options.mappings.OPTIONS) || [])) { %>\n  <div>\n    <label class='fb-option <%= rf.get(Formbuilder.options.mappings.CUSTOM_CSS_CLASS) %>  <%= rf.get(Formbuilder.options.mappings.RADIO) %> '>\n      <input  type='radio' <%= rf.get(Formbuilder.options.mappings.OPTIONS)[i].checked && 'checked' %> onclick=\"javascript: return false;\" class=\'<%= rf.get(Formbuilder.options.mappings.CUSTOM_CSS_CLASS) %> <%= rf.get(Formbuilder.options.mappings.VISIBILITY) %>\' /> \n  <%= rf.get(Formbuilder.options.mappings.OPTIONS)[i].label %>\n   </label>\n  </div>\n<% } %>\n\n<% if (rf.get(Formbuilder.options.mappings.INCLUDE_OTHER)) { %>\n  <div class='other-option'>\n    <label class='fb-option'>\n  <input type='radio' />\n    Other\n  </label>\n\n    <input type='text' />\n  </div>\n<% } %>",
    edit: " <%= Formbuilder.templates['edit/READONLY']() %><label id=\"readonlyid\">Read only</label><%= Formbuilder.templates['edit/visibility']() %>\n<%= Formbuilder.templates['edit/radio']() %>\n<%= Formbuilder.templates['edit/options']({ includeOther: true }) %>\n <%= Formbuilder.templates['edit/customcssclass']() %>",
    addButton: "<span class=\"symbol\"><span class=\"fa fa-list\"></span></span> Multiple Choice",
    defaultAttributes: function(attrs) {
      attrs.field_options.options = [
        {
          label: "Option1",
          checked: false
        }, {
          label: "Option2",
          checked: false
        }
      ];
    attrs.field_options.visibility = 'visible';
    attrs.field_options.radio = 'one_column';  
  
      return attrs;
    }
  });

}).call(this);


(function() {
  Formbuilder.registerField('section_break', {
    order: 17,
    type: 'non_input',
    view: "<label class='section-name'><%= rf.get(Formbuilder.options.mappings.LABEL) %></label>\n<p><%= rf.get(Formbuilder.options.mappings.DESCRIPTION) %></p>",
    edit: "<div class='fb-edit-section-header'>Label</div>\n<input type='text' data-rv-input='model.<%= Formbuilder.options.mappings.LABEL %>' />\n<textarea data-rv-input='model.<%= Formbuilder.options.mappings.DESCRIPTION %>'\n  placeholder='Add a longer description to this field'></textarea>",
    addButton: "<span class='symbol'><span class='fa fa-minus'></span></span> Section Break"
  });

}).call(this);


// Phone element
(function() {
  Formbuilder.registerField('phone', {
    order: 10,
    view: "<div class='elementdiv  <%= rf.get(Formbuilder.options.mappings.VISIBILITY) %><%= rf.get(Formbuilder.options.mappings.CUSTOM_CSS_CLASS) %>'><div class=\"phone-div\"><% if (Formbuilder.options.mappings.SELECTED_PHONE=='International'){ %>\n <input type='<%= rf.get(Formbuilder.options.mappings.PHONE) %>'value='<%= rf.get(Formbuilder.options.mappings.DEFAULT_VALUE_PHONE) %>' <%= rf.get(Formbuilder.options.mappings.VISIBILITY) %>/> <% }else{ %><div><input type=\"text\"value='<%= rf.get(Formbuilder.options.mappings.DEFAULT_VALUE_PHONE_INTERNATIONAL1) %>' style='width: 40px; padding: 5px; text-align: center;'/> - <input type=\"text\"value='<%= rf.get(Formbuilder.options.mappings.DEFAULT_VALUE_PHONE_INTERNATIONAL2) %>'  style='width: 40px; padding: 5px; text-align: center;'/> - <input type=\"text\"value='<%= rf.get(Formbuilder.options.mappings.DEFAULT_VALUE_PHONE_INTERNATIONAL3) %>' style='width: 60px; padding: 5px; text-align: center;'/> <div><% } %></div></div>",
    edit: " <%= Formbuilder.templates['edit/READONLY']() %><label id=\"readonlyid\">Read only</label><%= Formbuilder.templates['edit/visibility']() %>\n <%= Formbuilder.templates['edit/phone']() %>\n<div class=\"domestic\"> <%= Formbuilder.templates['edit/defaultvaluephone']() %> </div>\n <div class=\"ph_international\"><%= Formbuilder.templates['edit/defaultvaluephoneinternational']() %></div>\n<%= Formbuilder.templates['edit/customcssclass']() %>",
    addButton: "<span class=\"symbol\"><span class=\"fa fa-mobile-phone\"></span></span> Phone",
  defaultAttributes: function(attrs) {
         attrs.field_options.phone = 'International';
     attrs.field_options.visibility = 'visible';
      return attrs;
    }
  });

}).call(this);

/* Phone element*/


// slider 
(function() {
  //console.log('slider field here');
  Formbuilder.registerField('slider', {
    order: 20,
                            view: "<div class='elementdiv  <%= rf.get(Formbuilder.options.mappings.VISIBILITY) %><%= rf.get(Formbuilder.options.mappings.CUSTOM_CSS_CLASS) %>'><div class='slider'></div><div class='textcurrency'><input type='text' value='0'></div><div style=\"float:right;\"><%= EFBP_getCurrencySymbol(rf.get(Formbuilder.options.mappings.CURRENCY_SLIDER)) %></div><span class='optionalContent'><a class='linktext' target='_blank' href='<%= rf.get(Formbuilder.options.mappings.DEFAULT_URL) %>'><%= rf.get(Formbuilder.options.mappings.URL_TEXT) %></a></span></div><script>EFBP_callslider('<%= rf.get(Formbuilder.options.mappings.MIN) %>','<%= rf.get(Formbuilder.options.mappings.MAX) %>');</script>",
    edit: "<%= Formbuilder.templates['edit/min_max_slider']() %>\n<%= Formbuilder.templates['edit/customcssclass']() %>\n<%= Formbuilder.templates['edit/currencyslider']() %>\n<%= Formbuilder.templates['edit/visibility']() %>\n<%= Formbuilder.templates['edit/defaulturl']() %>\n<%= Formbuilder.templates['edit/urltext']() %>",
    addButton: "<span class='symbol'><span class=\"fa fa-sliders\"></span></span> Slider",
    defaultAttributes: function(attrs){
     attrs.field_options.MIN ='0';
     attrs.field_options.MAX ='100';
     attrs.field_options.visibility = 'visible';
   attrs.field_options.currencyslider='dollar';
      return attrs;
    }
  });
}).call(this);
/*end slider*/


// Name
(function() {
  Formbuilder.registerField('Name', {
    order: 7,
    view:  "<div class='full-text elementdiv <%= rf.get(Formbuilder.options.mappings.VISIBILITY) %> <%= rf.get(Formbuilder.options.mappings.CUSTOM_CSS_CLASS) %>'><% if (Formbuilder.options.mappings.SELECTED_NAME==\'Normal\'){%> <div class='normal'>\n <div class='col-md-2 col-sm-2 padding-left-none'><label style='width:100%;'>First </label>  <input type='text'  style=\"width: 50px;\"/></div>\n<div class='col-md-3 col-sm-3 padding-left-none'><label style='width:100%;'>Last</label>\n   <input type='text'  style=\"width: 80px;\"/></div>\n</div><%} else if(Formbuilder.options.mappings.SELECTED_NAME==\'Nor_title\') {%><div class='normal_title'> <div class='col-md-2 col-sm-2 padding-left-none'> <label style='width:100%;'> Title</label><input type=\"Text\"  style=\"width: 50px;\"/></div>\n<div class='col-md-2 col-sm-2 padding-left-none'> <label style='width:100%;'> First</label><input type=\"Text\"   style=\"width: 50px;\"/></div>\n<div class='col-md-3 col-sm-3 padding-left-none'> <label style='width:100%;'> Last </label><input type=\"Text\"   style=\"width:80px;\"/> </div>\n <div class='col-md-2 col-sm-2 padding-left-none'><label style='width:100%;'> Suffix </label><input type=\"Text\"  style=\"width:50px;\"/>\n </div></div> <%} else if (Formbuilder.options.mappings.SELECTED_NAME=='Full') {%> <div class=\"full\"><div class='col-md-2 col-sm-2 padding-left-none'><label style='width:100%;'> First</label>\n<input type=\"Text\"   style=\"width:50px;\"/></div><div class='col-md-2 col-sm-2 padding-left-none'><label style='width:100%;'> Middle </label>\n<input type=\"Text\"   style=\"width:50px;\"/></div><div class='col-md-3 col-sm-3 padding-left-none'><label style='width:100%;'> Last </label>\n<input type=\"Text\"  style=\"width:80px;\" /> </div></div> <%} else {%> <div class=\"full_title\"><div class='col-md-2 col-sm-2 padding-left-none'> <label style='width:100%;'> Title</label>\n<input type=\"Text\"  style=\"width:50px;\"/></div><div class='col-md-2 col-sm-2 padding-left-none'><label style='width:100%;'> First</label>\n<input type=\"Text\"   style=\"width: 50px;\"/></div><div class='col-md-2 col-sm-2 padding-left-none'><label style='width:100%;'> Middle </label>\n<input type=\"Text\"  style=\"width:60px;\" /> </div><div class='col-md-3 col-sm-3 padding-left-none'><label style='width:100%;'> Last </label>\n<input type=\"Text\"   style=\"width:80px;\"/></div><div class='col-md-2 col-sm-2 padding-left-none'><label style='width:100%;'>Suffix </label>\n<input type=\"Text\"  style=\"width: 60px;\"/></div><% }%></div> ",
    edit: " <%= Formbuilder.templates['edit/READONLY']() %><label id=\"readonlyid\">Read only</label><%= Formbuilder.templates['edit/name']() %>\n<%= Formbuilder.templates['edit/visibility']() %>\n <%= Formbuilder.templates['edit/customcssclass']() %>",
    addButton: "<span class=\"symbol\"><span class=\"fa fa-user\"></span></span> Name",
   defaultAttributes: function(attrs) {      
    attrs.field_options.name = 'Normal';
    attrs.field_options.visibility = 'visible';
      return attrs;
    }
  });

}).call(this);

/* Name */

// Toggle 
(function() {
  //console.log('toggle field here');
  Formbuilder.registerField('Toggle', {
    order: 21,
    view: "<div class='elementdiv <%= rf.get(Formbuilder.options.mappings.VISIBILITY) %><%= rf.get(Formbuilder.options.mappings.CUSTOM_CSS_CLASS) %>'><div class='toggle_button'><div class='onoffswitch'><input type='checkbox' name='onoffswitch' class='onoffswitch-checkbox' id='myonoffswitch' checked><label class='onoffswitch-label'><span class='onoffswitch-inner'></span><span class='onoffswitch-switch'></span></label></div></div></div>",
    edit: "<%= Formbuilder.templates['edit/visibility']() %>\n <%= Formbuilder.templates['edit/customcssclass']() %>",
    addButton: "<span class='symbol'><span class='fa fa-dot-circle-o'></span></span> Toggle",
    defaultAttributes: function(attrs) {      
   attrs.field_options.description = "Toggle";
   attrs.field_options.visibility = 'visible';
      return attrs;
    }
 });
}).call(this);
/*end Toggle */


// Signature
(function() {
Formbuilder.registerField('signature', {
    order: 19,
    view: "<div class='elementdiv <%= rf.get(Formbuilder.options.mappings.VISIBILITY) %> <%= rf.get(Formbuilder.options.mappings.CUSTOM_CSS_CLASS) %>'><label style=\"text-align:left; \"> <h5>Draw your signature in the box below </h5></label><div class='input-line'>\n  <span>\n    <input type=\"text\" style=\"width:290px; height:110px; text-align:center; backgroundColor:blue; \" placeholder=\"Signature Pad\" readonly> </span>\n  </div></div>",
    edit: "<%= Formbuilder.templates['edit/visibility']() %>\n <%= Formbuilder.templates['edit/customcssclass']() %>",
    addButton: "<span class=\"fa fa-pencil-square-o\"></span> Signature",
   defaultAttributes: function(attrs) {      
   attrs.field_options.visibility = 'visible';
      return attrs;
    }
  });

}).call(this);
/* Signature */


(function() {
  Formbuilder.registerField('text', {
    order: 0,
    view: "<div class='elementdiv  <%= rf.get(Formbuilder.options.mappings.VISIBILITY) %> <%= rf.get(Formbuilder.options.mappings.CUSTOM_CSS_CLASS) %>'><input type='<%= rf.get(Formbuilder.options.mappings.PASSWORD) %> ' class='rf-size-<%= rf.get(Formbuilder.options.mappings.SIZE) %>  ' value='<%= rf.get(Formbuilder.options.mappings.DEFAULT_VALUE) %>'  /></div>",
    edit: " <%= Formbuilder.templates['edit/READONLY']() %><label id=\"readonlyid\">Read only</label><%= Formbuilder.templates['edit/size']() %>\n <%= Formbuilder.templates['edit/visibility']() %>\n<%= Formbuilder.templates['edit/password']() %>\n<%= Formbuilder.templates['edit/min_max_length']() %> <%= Formbuilder.templates['edit/defaultvalue']() %> \n <%= Formbuilder.templates['edit/customcssclass']() %>",
    addButton: "<span class='symbol'><span class='fa fa-text-width'></span></span> Single Line Text",
    defaultAttributes: function(attrs) {
    attrs.field_options.size = 'small';
    attrs.field_options.password = 'text';
    attrs.field_options.visibility = 'visible';
    attrs.field_options.min_max_length_units='characters';
      return attrs;
    }
  });

}).call(this);

(function() {
  Formbuilder.registerField('file_upload', {
    order: 16,
    view: "<div class='input-line <%= rf.get(Formbuilder.options.mappings.VISIBILITY) %>  <%= rf.get(Formbuilder.options.mappings.CUSTOM_CSS_CLASS) %>'>\n  <span>\n    <input type=\"file\" onClick=  name=\"fileMulti[]\" disabled />\n  </span>\n  </div>",
    edit: "<%= Formbuilder.templates['edit/visibility']() %>\n<label> Upload options</label> <div class='border_checkbox' style=\"border:1px solid; border-color:#ddd; margin-top:2px; margin-bottom:2px;\"><%= Formbuilder.templates['edit/LIMIT_FIL_UPLOAD_TYPE']() %>  Limit File Upload Type <%= Formbuilder.templates['edit/fileup']() %><%= Formbuilder.templates['edit/LIMIT_FILE_UP_TXTAR']() %> <br> <%= Formbuilder.templates['edit/FILE_EMAIL_ATTACH']() %>   Send File As Email Attachment  <br></div><br><div style=\"border:solid 1px; border-color:#ddd;\"><label> Advanced uploader options</label> <br><%= Formbuilder.templates['edit/AUTO_UP_FILE']() %>  Automatically Upload Files <br><%= Formbuilder.templates['edit/MUL_FILE_UP']() %>  Allow Multiple File Upload <br>Limit selection to maximum<%= Formbuilder.templates['edit/LIMIT_MUL_FILE_UP']() %>files <br><%= Formbuilder.templates['edit/LIMIT_FILE_SIZE']() %> Limit File Size <br> Limit each file to a maximum <%= Formbuilder.templates['edit/LIMIT_MAX_FILEUP_SIZE']() %>MB </div>\n<%= Formbuilder.templates['edit/customcssclass']() %>",
    addButton: "<span class='symbol'><span class=\"fa fa-upload \"></span></span> File Upload",
   defaultAttributes: function(attrs) { 
    attrs.field_options.fileup = 'opt1';
  attrs.field_options.visibility = 'visible';
      return attrs;
    }
  });

}).call(this);


(function() {
  Formbuilder.registerField('time', {
    order: 9,
    view: "<div class='elementdiv <%= rf.get(Formbuilder.options.mappings.VISIBILITY) %>  <%= rf.get(Formbuilder.options.mappings.CUSTOM_CSS_CLASS) %>'>\n <% if (Formbuilder.options.mappings.SELECTED_TIME=='SecondField'){%><label>HH</label>\n <input type=\"Text\"  class=\"form-control\" style=\"width: 10%;display: inline;\" />\n  :<label>MM</label>\n<input type=\"text\" class=\"form-control\" style=\"width: 10%;display: inline;\" />\n:<label>SS</label>\n<input type=\"text\" class=\"form-control\" style=\"width: 10%;display: inline;\" />\n\n<select class=\"form-control\" style=\"width: 15%;display: inline;\">\n<option>AM</option>\n<option>PM</option>\n</select>\n<% } else if (Formbuilder.options.mappings.SELECTED_TIME=='HourFormat'){%> <label>HH</label>\n<input type=\"text\" class=\"form-control\" style=\"width: 10%;display: inline;\" />\n:\n<label>MM</label>\n<input type=\"text\" class=\"form-control\" style=\"width: 10%;display: inline;\" />\n   <% } else{  %>MM <input type=\"text\" class=\"form-control\" style=\"width: 10%;display: inline;\">  SS:\n <input type=\"text\" class=\"form-control\" style=\"width: 10%;display: inline;\">  MM:\n <input type=\"text\" class=\"form-control\" style=\"width: 10%;display: inline;\"> \n  <% } %>\n</div>",
    edit: " <%= Formbuilder.templates['edit/READONLY']() %><label id=\"readonlyid\">Read only</label><%= Formbuilder.templates['edit/visibility']() %>\n<%= Formbuilder.templates['edit/time']() %>\n<%= Formbuilder.templates['edit/customcssclass']() %>\n",
    addButton: "<span class=\"symbol\"><span class=\"fa fa-clock-o\"></span></span> Time",
  defaultAttributes: function(attrs) {
    attrs.field_options.visibility = 'visible';
    attrs.field_options.time = 'SecondField';
      return attrs;
    }
  });

}).call(this);

(function() {
  Formbuilder.registerField('website', {
    order: 12,
    view: "<div class='elementdiv <%= rf.get(Formbuilder.options.mappings.VISIBILITY) %>'><input type='text' class='rf-size-<%= rf.get(Formbuilder.options.mappings.SIZE) %>  <%= rf.get(Formbuilder.options.mappings.CUSTOM_CSS_CLASS) %>' value='<%= rf.get(Formbuilder.options.mappings.DEFAULT_VALUE) %>' placeholder='http://' /></div>",
    edit: " <%= Formbuilder.templates['edit/READONLY']() %><label id=\"readonlyid\">Read only</label><%= Formbuilder.templates['edit/size']() %>\n <%= Formbuilder.templates['edit/visibility']() %>\n<%= Formbuilder.templates['edit/defaultvalue']() %> \n <%= Formbuilder.templates['edit/customcssclass']() %>",
    addButton: "<span class=\"symbol\"><span class=\"fa fa-link\"></span></span> Website",
  defaultAttributes: function(attrs) {
    attrs.field_options.size = 'small';
    attrs.field_options.visibility = 'visible';
      return attrs;
    }
  });

}).call(this);

this["Formbuilder"] = this["Formbuilder"] || {};
this["Formbuilder"]["templates"] = this["Formbuilder"]["templates"] || {};

this["Formbuilder"]["templates"]["edit/base"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
  //console.log('view fieldName '+$("#form_label_alignment").val());
  $(".subtemplate-wrapper label:nth-child(2)").addClass($("#form_label_alignment").val());

  if(rf.get(Formbuilder.options.mappings.FIELD_TYPE)=="Toggle")
  {
    __p +=
    ((__t = ( Formbuilder.templates['edit/base_header']() )) == null ? '' : __t) +
    '\n' +
    ((__t = ( Formbuilder.templates['edit/commontoggle']() )) == null ? '' : __t) +
  '\n' +
    ((__t = ( Formbuilder.fields[rf.get(Formbuilder.options.mappings.FIELD_TYPE)].edit({rf: rf}) )) == null ? '' : __t) +
    '\n';
  }  
  else
 {
    __p +=
  ((__t = ( Formbuilder.templates['edit/base_header']() )) == null ? '' : __t) +
  '\n' +
  ((__t = ( Formbuilder.templates['edit/common']() )) == null ? '' : __t) +
  '\n' +
  ((__t = ( Formbuilder.fields[rf.get(Formbuilder.options.mappings.FIELD_TYPE)].edit({rf: rf}) )) == null ? '' : __t) +
  '\n';
 }

}
return __p
};

this["Formbuilder"]["templates"]["edit/base_header"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p += '<div class=\'fb-field-label\'>\n  <span data-rv-text="model.' +
((__t = ( Formbuilder.options.mappings.LABEL )) == null ? '' : __t) +
'"></span>\n  <code class=\'field-type\' data-rv-text=\'model.' +
((__t = ( Formbuilder.options.mappings.FIELD_TYPE )) == null ? '' : __t) +
'\'></code>\n  <span class=\'fa fa-arrow-right pull-right\'></span>\n</div>';

}
return __p
};

// Radio button
this["Formbuilder"]["templates"]["edit/radio"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p += '<div class=\'fb-edit-section-header\'>Multiple Choice</div>\n<select class="form-control" data-rv-value="model.' +
((__t = ( Formbuilder.options.mappings.RADIO )) == null ? '' : __t) +
'">\n  <option value="one_column">One_Column</option>\n  <option value="two_column">Two_Column</option>\n  <option value="three_column">Three_Column</option>\n<option value="inline">Inline</option>\n  </select>\n <br></div>';

}
return __p
};
/* radio button ends*/

// email

// Email
this["Formbuilder"]["templates"]["edit/defaultValEmail"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p += '<div class=\'fb-edit-section-header\'>Default Value</div>\n<input  style=\"width:200px;\"  class="form-control" type=\"text\" data-rv-value="model.' +
((__t = ( Formbuilder.options.mappings.DEFAULT_VAL_EMAIL )) == null ? '' : __t) +
'">\n';
}
return __p
};
// email ends

//Capcha 
this["Formbuilder"]["templates"]["edit/site_key"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p += '<div class=\'fb-edit-section-header\'>Site key <div>\n<input class="form-control" type=\'text\'  data-rv-value="model.' +
((__t = ( Formbuilder.options.mappings.SITE_KEY )) == null ? '' : __t) +
'">\n';
}
return __p
};

this["Formbuilder"]["templates"]["edit/secreat_key"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p += '<div class=\'fb-edit-section-header\'>Secret key <div>\n<input class="form-control" type=\'text\'  data-rv-value="model.' +
((__t = ( Formbuilder.options.mappings.SECREAT_KEY )) == null ? '' : __t) +
'">\n';
}
return __p
};

// Capcha ends

// file upload
this["Formbuilder"]["templates"]["edit/fileup"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p += '<div class=\'fb-edit-section-header\'></div>\n<select data-rv-value="model.' +
((__t = ( Formbuilder.options.mappings.FILEUP)) == null ? '' : __t) +
'">\n  <option value="opt1">Block</option>\n  <option value="opt2">Only Allow</option>\n </select> files listed below. \n';

}
return __p
};

this["Formbuilder"]["templates"]["edit/LIMIT_FIL_UPLOAD_TYPE"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p += '<input  checked=\"true\"  type=\'checkbox\' data-rv-checked=\'model.' +
((__t = ( Formbuilder.options.mappings.LIMIT_FIL_UPLOAD_TYPE )) == null ? '' : __t) +
'\' />';
}
return __p
};

this["Formbuilder"]["templates"]["edit/FILE_EMAIL_ATTACH"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p += '<input  checked=\"true\"  type=\'checkbox\' data-rv-checked=\'model.' +
((__t = ( Formbuilder.options.mappings.FILE_EMAIL_ATTACH )) == null ? '' : __t) +
'\' />';
}
return __p
};

this["Formbuilder"]["templates"]["edit/AUTO_UP_FILE"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p += '<input  checked=\"true\"  type=\'checkbox\' data-rv-checked=\'model.' +
((__t = ( Formbuilder.options.mappings.AUTO_UP_FILE )) == null ? '' : __t) +
'\' />';
}
return __p
};

this["Formbuilder"]["templates"]["edit/MUL_FILE_UP"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p += '<input  checked=\"true\"  type=\'checkbox\' data-rv-checked=\'model.' +
((__t = ( Formbuilder.options.mappings.MUL_FILE_UP )) == null ? '' : __t) +
'\' />';
}
return __p
};


this["Formbuilder"]["templates"]["edit/LIMIT_FILE_SIZE"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p += '<input  checked=\"true\"  type=\'checkbox\' data-rv-checked=\'model.' +
((__t = ( Formbuilder.options.mappings.LIMIT_FILE_SIZE )) == null ? '' : __t) +
'\' />';
}
return __p
};


this["Formbuilder"]["templates"]["edit/LIMIT_MUL_FILE_UP"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p += '<input style="width: 30px;" type=/"checkbox/"   data-rv-value="model.' + 
((__t = ( Formbuilder.options.mappings.LIMIT_MUL_FILE_UP )) == null ? '' : __t) +
'" />';
}
return __p
};

this["Formbuilder"]["templates"]["edit/LIMIT_MAX_FILEUP_SIZE"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p += '<input style="width: 30px;" type=/"checkbox/"   data-rv-value="model.' + 
((__t = ( Formbuilder.options.mappings.LIMIT_MAX_FILEUP_SIZE )) == null ? '' : __t) +
'" />';
}
return __p
};

this["Formbuilder"]["templates"]["edit/LIMIT_FILE_UP_TXTAR"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p += '<textarea placeholder=\"File types: .htm, .html,.exe,.php3,.php4,.php5\" data-rv-value="model.' + 
((__t = ( Formbuilder.options.mappings.LIMIT_FILE_UP_TXTAR )) == null ? '' : __t) +
'" ></textarea>';
}
return __p
};
// file upload ends

this["Formbuilder"]["templates"]["edit/base_non_input"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p +=
((__t = ( Formbuilder.templates['edit/base_header']() )) == null ? '' : __t) +
'\n' +
((__t = ( Formbuilder.fields[rf.get(Formbuilder.options.mappings.FIELD_TYPE)].edit({rf: rf}) )) == null ? '' : __t) +
'\n';

}
return __p
};

// Checkboxes 
this["Formbuilder"]["templates"]["edit/checkbox"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p += '<div class=\'fb-edit-section-header\'> Checkboxes </div>\n<select class="form-control" data-rv-value="model.' +
((__t = ( Formbuilder.options.mappings.CHECKBOX)) == null ? '' : __t) +
'">\n  <option value="one_column">One_Column</option>\n  <option value="two_column">Two_Column</option>\n  <option value="three_column">Three_Column</option>\n<option value="inline">Inline</option>\n  </select>\n </div>';

}
return __p
};
/* Checkbox ends*/

this["Formbuilder"]["templates"]["edit/checkboxes"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p += '<label>\n  <input type=\'checkbox\' data-rv-checked=\'model.' +
((__t = ( Formbuilder.options.mappings.REQUIRED )) == null ? '' : __t) +
'\' />\n  Required\n</label>\n<!-- label>\n  <input type=\'checkbox\' data-rv-checked=\'model.' +
((__t = ( Formbuilder.options.mappings.ADMIN_ONLY )) == null ? '' : __t) +
'\' />\n  Admin only\n</label -->';

}
return __p
};

// FOR read only checkbox
this["Formbuilder"]["templates"]["edit/READONLY"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p += '<input  for= "readonlyid" type=\'checkbox\'  data-rv-checked=\'model.' +
((__t = ( Formbuilder.options.mappings.READ_ONLY )) == null ? '' : __t) +
'\' />\n';
}
return __p
};


//set US restricted
this["Formbuilder"]["templates"]["edit/setusrestrcted"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p += '<input id="restrictme" type=\'checkbox\'  data-rv-checked=\'model.' +
((__t = ( Formbuilder.options.mappings.ADDRESS_USRESTRICT )) == null ? '' : __t) +
'\' />\n  <label>U.S restricted states \n</label>\n';

}
return __p
};

this["Formbuilder"]["templates"]["edit/common"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p += '<div class=\'fb-edit-section-header\'>Label</div>\n\n<div class=\'fb-common-wrapper\'>\n  <div class=\'fb-label-description\'>\n    ' +
((__t = ( Formbuilder.templates['edit/label_description']() )) == null ? '' : __t) +
'\n  </div>\n  <div class=\'fb-common-checkboxes\'>\n    ' +
((__t = ( Formbuilder.templates['edit/checkboxes']() )) == null ? '' : __t) +
'\n  </div>\n  <div class=\'fb-clear\'></div>\n</div>\n';

}
return __p
};

this["Formbuilder"]["templates"]["edit/integer_only"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p += '<div class=\'fb-edit-section-header\'>Integer only</div>\n<label>\n  <input type=\'checkbox\' data-rv-checked=\'model.' +
((__t = ( Formbuilder.options.mappings.INTEGER_ONLY )) == null ? '' : __t) +
'\' />\n  Only accept integers\n</label>\n';

}
return __p
};

/* SEt only toggle label*/
this["Formbuilder"]["templates"]["edit/label_toggle"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p += '<textarea class="form-control" data-rv-input=\'model.' +
((__t = ( Formbuilder.options.mappings.DESCRIPTION )) == null ? '' : __t) +
'\'\n  placeholder=\'Please enter toggle label. \'></textarea>';

}
return __p
};

/*End set only toggle value*/
this["Formbuilder"]["templates"]["edit/label_description"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p += '<input class="form-control" type=\'text\' data-rv-input=\'model.' +
((__t = ( Formbuilder.options.mappings.LABEL )) == null ? '' : __t) +
'\' />\n<textarea class="form-control" data-rv-input=\'model.' +
((__t = ( Formbuilder.options.mappings.DESCRIPTION )) == null ? '' : __t) +
'\'\n  placeholder=\'Add a longer description to this field\'></textarea>';

}
return __p
};

this["Formbuilder"]["templates"]["edit/min_max"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p += '<div class=\'fb-edit-section-header\'>Minimum / Maximum</div>\n\nAbove\n<input type="text" data-rv-input="model.' +
((__t = ( Formbuilder.options.mappings.MIN )) == null ? '' : __t) +
'" style="width: 50px" />\n\n&nbsp;&nbsp;\n\nBelow\n<input type="text" data-rv-input="model.' +
((__t = ( Formbuilder.options.mappings.MAX )) == null ? '' : __t) +
'" style="width: 50px" />\n';
}
return __p
};



this["Formbuilder"]["templates"]["edit/min_max_length"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p += '<div class=\'fb-edit-section-header\'>Length Limit</div>\n\nMin\n<input type="text" data-rv-input="model.' +
((__t = ( Formbuilder.options.mappings.MINLENGTH )) == null ? '' : __t) +
'" style="width: 40px" />\n\n&nbsp;&nbsp;\n\nMax\n<input type="text" data-rv-input="model.' +
((__t = ( Formbuilder.options.mappings.MAXLENGTH )) == null ? '' : __t) +
'" style="width: 40px" />\n\n&nbsp;&nbsp;\n\n<select class="form-control" data-rv-value="model.' +
((__t = ( Formbuilder.options.mappings.LENGTH_UNITS )) == null ? '' : __t) +
'" style="width: auto;">\n  <option value="characters">Characters</option>\n  <option value="words">Words</option>\n</select>\n';

}
return __p
};


// Set slider min/ max
this["Formbuilder"]["templates"]["edit/min_max_slider"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p += '<div class=\'fb-edit-section-header\'>Minimum / Maximum</div>\n\nMIN\n<input type="text" data-rv-input="model.' +
((__t = ( Formbuilder.options.mappings.MIN )) == null ? '0' : __t) +
'" style="width: 60px" />\n\n&nbsp;&nbsp;\n\nMAX\n<input type="text" data-rv-input="model.' +
((__t = ( Formbuilder.options.mappings.MAX )) == null ? '100' : __t) +
'" style="width: 60px" />\n';
}
return __p
};
/* Set Slider min/max */

this["Formbuilder"]["templates"]["edit/options"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape, __j = Array.prototype.join;
function print() { __p += __j.call(arguments, '') }
with (obj) {
__p += '<div class=\'fb-edit-section-header\'>Options</div>\n\n';
 if (typeof includeBlank !== 'undefined'){ ;
__p += '\n  <label>\n    <input type=\'checkbox\' data-rv-checked=\'model.' +
((__t = ( Formbuilder.options.mappings.INCLUDE_BLANK )) == null ? '' : __t) +
'\' />\n    Include blank\n  </label>\n';
 } ;
__p += '\n\n<div class=\'option\' data-rv-each-option=\'model.' +
((__t = ( Formbuilder.options.mappings.OPTIONS )) == null ? '' : __t) +
'\'>\n  <input type="checkbox" class=\'js-default-updated\' data-rv-checked="option:checked" />\n  <input type="text" data-rv-input="option:label" class=\'option-label-input\' />\n  <a class="js-add-option ' +
((__t = ( Formbuilder.options.BUTTON_CLASS )) == null ? '' : __t) +
'" title="Add Option"><i class=\'fa fa-plus-circle\'></i></a>\n  <a class="js-remove-option ' +
((__t = ( Formbuilder.options.BUTTON_CLASS )) == null ? '' : __t) +
'" title="Remove Option"><i class=\'fa fa-minus-circle\'></i></a>\n</div>\n\n';
 if (typeof includeOther !== 'undefined'){ ;
__p += '\n  <label>\n    <input type=\'checkbox\' data-rv-checked=\'model.' +
((__t = ( Formbuilder.options.mappings.INCLUDE_OTHER )) == null ? '' : __t) +
'\' />\n    Include "other"\n  </label>\n';
 } ;
__p += '\n\n<div class=\'fb-bottom-add\'>\n  <a class="js-add-option ' +
((__t = ( Formbuilder.options.BUTTON_CLASS )) == null ? '' : __t) +
'">Add option</a>\n</div>\n';

}
return __p
};

// set togglelabel
this["Formbuilder"]["templates"]["edit/commontoggle"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p += '<div class=\'fb-edit-section-header\'>Label</div>\n\n<div class=\'fb-common-wrapper\'>\n  <div class=\'fb-label-description\'>\n    ' +
((__t = ( Formbuilder.templates['edit/label_toggle']() )) == null ? '' : __t) +
'\n  </div>\n <div class=\'fb-clear\'></div>\n</div>\n';

}
return __p
};
/* default value */

// Deafult country 
this["Formbuilder"]["templates"]["edit/defaultcountry"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape,i=0;
with (obj) {
__p += '<div class=\'fb-edit-section-header\'>Default Country</div>\n<select class="form-control" id="defaultcountry" data-rv-value="model.' +
((__t = ( Formbuilder.options.mappings.DEFAULT_COUNTRY )) == null ? '' : __t) +
'"><=% if(Formbuilder.options.mappings.DEFAULT_COUNTRY!="" && Formbuilder.options.mappings.ADDRESS_USRESTRICT!=false) {%><option>Afghanistan</option><option>Albania</option> <option>Algeria</option> <option>Andorra</option> <option>Angola</option> <option>Anguilla</option> <option>Antigua &amp; Barbuda</option> <option>Argentina</option> <option>Armenia</option> <option>Aruba</option> <option>Australia</option> <option>Austria</option> <option>Azerbaijan</option> <option>Bahamas</option> <option>Bahrain</option> <option>Bangladesh</option> <option>Barbados</option> <option>Belarus</option> <option>Belgium</option> <option>Belize</option> <option>Benin</option> <option>Bermuda</option> <option>Bhutan</option> <option>Bolivia</option> <option>Bosnia &amp; Herzegovina</option> <option>Botswana</option> <option>Brazil</option> <option>British Virgin Islands</option> <option>Brunei</option> <option>Bulgaria</option> <option>Burkina Faso</option> <option>Burundi</option> <option>Cambodia</option> <option>Cameroon</option> <option>Cape Verde</option> <option>Cayman Islands</option> <option>Chad</option> <option>Chile</option> <option>China</option> <option>Colombia</option> <option>Congo</option> <option>Cook Islands</option> <option>Costa Rica</option> <option>Cote D Ivoire</option> <option>Croatia</option> <option>Cruise Ship</option> <option>Cuba</option> <option>Cyprus</option> <option>Czech Republic</option> <option>Denmark</option> <option>Djibouti</option> <option>Dominica</option> <option>Dominican Republic</option> <option>Ecuador</option> <option>Egypt</option> <option>El Salvador</option> <option>Equatorial Guinea</option> <option>Estonia</option> <option>Ethiopia</option> <option>Falkland Islands</option> <option>Faroe Islands</option> <option>Fiji</option> <option>Finland</option> <option>France</option> <option>French Polynesia</option> <option>French West Indies</option> <option>Gabon</option> <option>Gambia</option> <option>Georgia</option> <option>Germany</option> <option>Ghana</option> <option>Gibraltar</option> <option>Greece</option> <option>Greenland</option> <option>Grenada</option> <option>Guam</option> <option>Guatemala</option> <option>Guernsey</option> <option>Guinea</option> <option>Guinea Bissau</option> <option>Guyana</option> <option>Haiti</option> <option>Honduras</option> <option>Hong Kong</option> <option>Hungary</option> <option>Iceland</option> <option>India</option> <option>Indonesia</option> <option>Iran</option> <option>Iraq</option> <option>Ireland</option> <option>Isle of Man</option> <option>Israel</option> <option>Italy</option> <option>Jamaica</option> <option>Japan</option> <option>Jersey</option> <option>Jordan</option> <option>Kazakhstan</option> <option>Kenya</option> <option>Kuwait</option> <option>Kyrgyz Republic</option> <option>Laos</option> <option>Latvia</option> <option>Lebanon</option> <option>Lesotho</option> <option>Liberia</option> <option>Libya</option> <option>Liechtenstein</option> <option>Lithuania</option> <option>Luxembourg</option> <option>Macau</option> <option>Macedonia</option> <option>Madagascar</option> <option>Malawi</option> <option>Malaysia</option> <option>Maldives</option> <option>Mali</option> <option>Malta</option> <option>Mauritania</option> <option>Mauritius</option> <option>Mexico</option> <option>Moldova</option> <option>Monaco</option> <option>Mongolia</option> <option>Montenegro</option> <option>Montserrat</option> <option>Morocco</option> <option>Mozambique</option> <option>Namibia</option> <option>Nepal</option> <option>Netherlands</option> <option>Netherlands Antilles</option> <option>New Caledonia</option> <option>New Zealand</option> <option>Nicaragua</option> <option>Niger</option> <option>Nigeria</option> <option>Norway</option> <option>Oman</option> <option>Pakistan</option> <option>Palestine</option> <option>Panama</option> <option>Papua New Guinea</option> <option>Paraguay</option> <option>Peru</option> <option>Philippines</option> <option>Poland</option> <option>Portugal</option> <option>Puerto Rico</option> <option>Qatar</option> <option>Reunion</option> <option>Romania</option> <option>Russia</option> <option>Rwanda</option> <option>Saint Pierre &amp; Miquelon</option> <option>Samoa</option> <option>San Marino</option> <option>Satellite</option> <option>Saudi Arabia</option> <option>Senegal</option> <option>Serbia</option> <option>Seychelles</option> <option>Sierra Leone</option> <option>Singapore</option> <option>Slovakia</option> <option>Slovenia</option> <option>South Africa</option> <option>South Korea</option> <option>Spain</option> <option>Sri Lanka</option> <option>St Kitts &amp; Nevis</option> <option>St Lucia</option> <option>St Vincent</option> <option>St. Lucia</option> <option>Sudan</option> <option>Suriname</option> <option>Swaziland</option> <option>Sweden</option> <option>Switzerland</option> <option>Syria</option> <option>Taiwan</option> <option>Tajikistan</option> <option>Tanzania</option> <option>Thailand</option> <option>Timor L\'Este</option> <option>Togo</option> <option>Tonga</option> <option>Trinidad &amp; Tobago</option> <option>Tunisia</option> <option>Turkey</option> <option>Turkmenistan</option> <option>Turks &amp; Caicos</option> <option>Uganda</option> <option>Ukraine</option><option>United States</option>  <option>United Arab Emirates</option> <option>United Kingdom</option> <option>Uruguay</option> <option>Uzbekistan</option> <option>Venezuela</option> <option>Vietnam</option> <option>Virgin Islands (US)</option> <option>Yemen</option> <option>Zambia</option> <option>Zimbabwe</option> <option>United States</option> %>}%></select>\n';
}
return __p
};
//End default country

// set default value
this["Formbuilder"]["templates"]["edit/defaultvalue"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p += '<div class=\'fb-edit-section-header\'>Default Value</div>\n<input  style=\"width:200px;\"  class="form-control" type=\'text\'  data-rv-value="model.' +
((__t = ( Formbuilder.options.mappings.DEFAULT_VALUE )) == null ? '' : __t) +
'">\n';
}

return __p
};
/* default value */

// set defaulturl
this["Formbuilder"]["templates"]["edit/defaulturl"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p += '<div class=\'fb-edit-section-header\'>Default URL</div>\n<input class="form-control" type=\'text\'  data-rv-value="model.' +
((__t = ( Formbuilder.options.mappings.DEFAULT_URL )) == null ? '' : __t) +
'">\n';
}
return __p
};
/* defaulturl */

// set urltext
this["Formbuilder"]["templates"]["edit/urltext"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p += '<div class=\'fb-edit-section-header\'>URL Text<div>\n<input class="form-control" type=\'text\'  data-rv-value="model.' +
((__t = ( Formbuilder.options.mappings.URL_TEXT )) == null ? '' : __t) +
'">\n';
}
return __p
};
/* urltext */




// set default value textarea
this["Formbuilder"]["templates"]["edit/defaultvaluetextarea"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p += '<div class=\'fb-edit-section-header\'>Default Value</div>\n<textarea  style=\"width:200px;\"  class="form-control" data-rv-value="model.' +
((__t = ( Formbuilder.options.mappings.DEFAULT_VALUE_TEXTAREA )) == null ? '' : __t) +
'"></textarea>\n';
}
return __p
};
/* default value textarea */


// set password type
this["Formbuilder"]["templates"]["edit/password"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p += '<div class=\'fb-edit-section-header\'>Display As Password Field</div>\n<select  style=\"width:120px;\" class="form-control" data-rv-value="model.' +
((__t = ( Formbuilder.options.mappings.PASSWORD )) == null ? '' : __t) +
'">\n  <option value="text">TEXT</option>\n  <option value="password">PASSWORD</option>\n </select>\n';

}
return __p
};
/* password*/

// Visibility
this["Formbuilder"]["templates"]["edit/visibility"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p += '<div class=\'fb-edit-section-header visible\'>Field Visibility</div>\n<select style=\"width:120px;\" class="form-control" data-rv-value="model.' +
((__t = ( Formbuilder.options.mappings.VISIBILITY )) == null ? '' : __t) +
'">\n  <option value="visible">Visible</option>\n  <option value="hidden">Hidden</option>\n  <option value="adminonly">Admin Only</option>\n</select>\n';

}
return __p
};
/* Visibility*/


// customcssclass
this["Formbuilder"]["templates"]["edit/customcssclass"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p += '<div class=\'fb-edit-section-header\'>Custom CSS Class</div>\n<input  style=\"width:200px;\"  class="form-control" type=\'text\' data-rv-value="model.' +
((__t = ( Formbuilder.options.mappings.CUSTOM_CSS_CLASS )) == null ? '' : __t) +
'">\n';

}
return __p
};
/* customcssclass*/

// Start Date Format
this["Formbuilder"]["templates"]["edit/dateformat"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p +=  '<div class=\'fb-edit-section-header\'>Field Date</div>\n<select id =\"drop_dwn_date\"onChange=\"if(this.options[this.selectedIndex].innerHTML!=\'MM / DD / YYYY\'){ Formbuilder.options.mappings.SELECTED_DATE=\'date2\';}else{Formbuilder.options.mappings.SELECTED_DATE=\'date1\';}\" data-rv-value="model.'+
((__t = ( Formbuilder.options.mappings.DATE)) == null ? '' : __t) +
'">\n  <option value="date1" >MM / DD / YYYY</option>\n  <option value="date2">DD / MM / YYYY</option>\n</select>\n';
}
return __p
};

// date fix default val min
this["Formbuilder"]["templates"]["edit/datevalfixmin"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p += '<div class=\'fb-edit-section-header\'>Minimum date:\n<input id=\'datepicker\' type=\'text\'  data-rv-value="model.' +
((__t = ( Formbuilder.options.mappings.DATE_VALUE_FIX_MIN )) == null ? '' : __t) +
'"> </div>\n';
}

return __p
};

// date  fix default val max
this["Formbuilder"]["templates"]["edit/datevalfixmax"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p += '<div class=\'fb-edit-section-header\'>Maximum date:\n<input id=\'datepicker1\' type=\'text\'  data-rv-value="model.' +
((__t = ( Formbuilder.options.mappings.DATE_VALUE_FIX_MAX )) == null ? '' : __t) +
'"> </div>\n';
}

return __p
};

// date rel default val min
this["Formbuilder"]["templates"]["edit/datevalRelmin"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p += '<div class=\'fb-edit-section-header\'>Minimum days:\n<input  type=\'text\'  data-rv-value="model.' +
((__t = ( Formbuilder.options.mappings.DATE_VALUE_REL_MIN )) == null ? '' : __t) +
'"> </div>\n';
}

return __p
};

// date  rel default val max
this["Formbuilder"]["templates"]["edit/datevalRelmax"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p += '<div class=\'fb-edit-section-header\'>Maximum days:\n<input id=\'datepicker4\' type=\'text\'  data-rv-value="model.' +
((__t = ( Formbuilder.options.mappings.DATE_VALUE_REL_MAX )) == null ? '' : __t) +
'"> </div>\n';
}

return __p
};
// enable date selection limit
this["Formbuilder"]["templates"]["edit/EnDtSelLimit"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p += '<input style=\"width:30px;\" type=\'text\'  data-rv-value="model.' +
((__t = ( Formbuilder.options.mappings.DATE_EN_SELECTION_LIMIT )) == null ? '' : __t) +
'">\n';
}

return __p
};

// Date Fixed/Relative
this["Formbuilder"]["templates"]["edit/datefixedrelative"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p +=  'Set range using <select id =\"drop_dwn_date\"onchange=\"if(this.options[this.selectedIndex].innerHTML==\'fixed\'){$(\'#prop_date_range_fixed\').show();$(\'#prop_date_range_relative\').hide();}else{$(\'#prop_date_range_fixed\').hide();$(\'#prop_date_range_relative\').show();}\" data-rv-value="model.'+
((__t = ( Formbuilder.options.mappings.DATE_FX_REL)) == null ? '' : __t) +
'">\n  <option value="fixed" >fixed</option>\n  <option value="relative">relative</option>\n</select>dates:\n';
}
return __p
};


this["Formbuilder"]["templates"]["edit/defaultval_date"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p += '<div class=\'fb-edit-section-header\'>Default Date(mm/dd/yyyy)</div>\n<input class="form-control" onKeyUp=\'var str=this.value;    var dateObj = new Date(str);var month = dateObj.getUTCMonth() + 1;var day = dateObj.getUTCDate()+1;var year = dateObj.getUTCFullYear();Formbuilder.options.mappings.DATE_DD=day;Formbuilder.options.mappings.DATE_MM=month;Formbuilder.options.mappings.DATE_YYYY=year;\' type=\'text\'  data-rv-value="model.' +
((t = ( Formbuilder.options.mappings.DEFAULT_VALUE_DATE )) == null ? '' : t) +
'">\n';
}
return __p
};

this["Formbuilder"]["templates"]["edit/defaultminval_date"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p += '<div class=\'fb-edit-section-header\'>Minimum Date:(mm/dd/yyyy)</div>\n<input type=\'text\'  data-rv-value="model.' +
((t = ( Formbuilder.options.mappings.DEFAULT_VALUE_MINDATE )) == null ? '' : t) +
'">\n';
}
return __p
};

this["Formbuilder"]["templates"]["edit/defaultmaxval_date"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p += '<div class=\'fb-edit-section-header\'>Maximum Date:(mm/dd/yyyy)</div>\n<input type=\'text\'  data-rv-value="model.' +
((t = ( Formbuilder.options.mappings.DEFAULT_VALUE_MAXDATE )) == null ? '' : t) +
'">\n';
}
return __p
};

this["Formbuilder"]["templates"]["edit/ENABLEMINMAXDATE"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p += '<input id="prop_date_range" onchange=\"if(this.checked){if(document.getElementById(\'prop_date_past_future_selection\').checked==true){$( \'#prop_date_past_future_selection\' ).trigger( \'click\' );$(\'#prop_date_past_future_selection\').attr(\'checked\', false);}$(\'#prop_date_range_details\').show();this.checked=true;}else{$(\'#prop_date_range_details\').hide()}" type=\'checkbox\' data-rv-checked=\'model.' +
((__t = ( Formbuilder.options.mappings.ENABLEMINMAXDATE )) == null ? '' : __t) +
'\' />';

}
return __p
};

this["Formbuilder"]["templates"]["edit/ENABLEDATELIMIT"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p += '<input id=\'prop_date_selection_limit\' onchange=\"$(\'#form_date_selection_limit\').toggle();\" type=\'checkbox\' data-rv-checked=\'model.' +
((__t = ( Formbuilder.options.mappings.ENABLEDATELIMIT )) == null ? '' : __t) +
'\' />';

}
return __p
};

this["Formbuilder"]["templates"]["edit/DISABLEPASTFURDATE"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p += '<input id=\'prop_date_past_future_selection\' onchange=\"if(this.checked){if(document.getElementById(\'prop_date_range\').checked==true){$( \'#prop_date_range\' ).trigger( \'click\' );$(\'#prop_date_range\').attr(\'checked\', false);}$(\'#prop_date_range_details\').hide();}\" type=\'checkbox\' data-rv-checked=\'model.' +
((__t = ( Formbuilder.options.mappings.DISABLEPASTFURDATE )) == null ? '' : __t) +
'\' />';

}
return __p
};

// PASTFUTURE function
this["Formbuilder"]["templates"]["edit/ALLPASTFURDATE"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {  
__p += '<select id =\"drop_dwn\" data-rv-value="model.' +
((__t = ( Formbuilder.options.mappings.ALLPASTFURDATE )) == null ? '' : __t) +
'">\n  <option value="past">All past dates</option>\n  <option value="future">All future dates</option>\n </select>\n';
}
return __p
};

this["Formbuilder"]["templates"]["edit/DISABLEWEEKENDDATE"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p += '<input id=\'prop_date_disable_weekend\'  type=\'checkbox\' class=\'checkbox\' data-rv-checked=\'model.' +
((__t = ( Formbuilder.options.mappings.DISABLEWEEKENDDATE )) == null ? '' : __t) +
'\' />';
}
return __p
};

this["Formbuilder"]["templates"]["edit/DISABLESPCDATE"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p += '<input id=\'prop_date_disable_specific\'  type=\'checkbox\' class=\'checkbox\' data-rv-checked=\'model.' +
((__t = ( Formbuilder.options.mappings.DISABLESPCDATE )) == null ? '' : __t) +
'\' />';
}
return __p
};

this["Formbuilder"]["templates"]["edit/DISABLESPCDATETXTAREA"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p += '<textarea class="form-control"  id=\'date_disabled_list\' style=\'width: 200px;height: 50px\' cols=\'100\' rows=\'10\' class=\'textarea hasDatepick\' data-rv-checked=\'model.' +
((__t = ( Formbuilder.options.mappings.DISABLESPCDATETXTAREA )) == null ? '' : __t) +
'\' >';
if(Formbuilder.options.mappings.DISABLESPCDATETXTAREA=='field_options.DISABLESPCDATETXTAREA'){
__p+='</textarea><br><input id=\'datepicker2\' type=\'text\' placeholder=\'Click here to append dates \' onchange="if(document.getElementById(\'date_disabled_list\').value!=\'\'){document.getElementById(\'date_disabled_list\').value=document.getElementById(\'date_disabled_list\').value+\',\'+this.value;this.value=\'\';}else{document.getElementById(\'date_disabled_list\').value=this.value;this.value=\'\';}$( \'#date_disabled_list\' ).trigger( \'change\' );" style=\"width:200px; height:40px;\" />';
  
}
else{
__p+='</textarea><br><input id=\'datepicker2\' type=\'text\' placeholder=\'Click here to append dates \' onchange="if(document.getElementById(\'date_disabled_list\').value!=\'\'){document.getElementById(\'date_disabled_list\').value=document.getElementById(\'date_disabled_list\').value+\',\'+this.value;this.value=\'\';}else{document.getElementById(\'date_disabled_list\').value=this.value;this.value=\'\';}$( \'#date_disabled_list\' ).trigger( \'change\' );" style=\"width:200px; height:40px;\" />';
  
}

}
return __p
};
/* Date Format */ 

/* Time  */
  this["Formbuilder"]["templates"]["edit/time"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {  
__p += '<div class=\'fb-edit-section-header\'>Field time</div>\n<select class="form-control" id =\"time_drp_dwn\"onChange=\"if(this.options[this.selectedIndex].innerHTML==\'Show_Seconds_Field\'){  Formbuilder.options.mappings.SELECTED_TIME=\'SecondField\';}else if(this.options[this.selectedIndex].innerHTML==\'24_Hour_Format\'){ Formbuilder.options.mappings.SELECTED_TIME=\'HourFormat\';} else{ Formbuilder.options.mappings.SELECTED_TIME=\'both\';}\" data-rv-value="model.' +
((__t = ( Formbuilder.options.mappings.TIME )) == null ? '' : __t) +
'">\n  <option value="SecondField">Show_Seconds_Field</option>\n  <option value="HourFormat">24_Hour_Format</option>\n<option value="both">24_Hour_Format_and_seconds</option>\n </select>\n ';
}
return __p
};
/* Time ends */

// Phone function
this["Formbuilder"]["templates"]["edit/phone"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {  
__p += '<div class=\'fb-edit-section-header\'>Field phone</div>\n<select class="form-control" id =\"drop_dwn\"onChange=\"if(this.options[this.selectedIndex].innerHTML!=\'International\'){Formbuilder.options.mappings.SELECTED_PHONE=\'NotInternational\';}else{Formbuilder.options.mappings.SELECTED_PHONE=\'International\';}\" data-rv-value="model.' +
((__t = ( Formbuilder.options.mappings.PHONE )) == null ? '' : __t) +
'">\n  <option value="International">International</option>\n  <option value="phone_number">###-###-####</option>\n </select>\n <script>$("#drop_dwn").change(function(){ if($("#drop_dwn").val()==\'International\'){$(".default_value_international").show(); $(".hide_domestic").hide();}else if($("#drop_dwn").val()==\'phone_number\'){$(".hide_domestic").show();  $(".default_value_international").hide(); }});</script>';
}
return __p
};
// Currency function
this["Formbuilder"]["templates"]["edit/currency"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {  
__p += '<div class=\'fb-edit-section-header\'>Currency</div>\n<select  id="currencyID"  class="form-control"  data-rv-value="model.' +
((__t = ( Formbuilder.options.mappings.CURRENCY )) == null ? '' : __t) +
'"><option value="dollar" id="element_money_usd" ></option><option value="euro" id="element_money_euro" >€ - Euros</option><option value="pound" id="element_money_pound" >£ - Pounds Sterling</option><option value="yen" id="element_money_yen">¥ - Yen</option><option value="baht" id="element_money_baht"  >฿ - Baht</option><option value="forint" id="element_money_forint" >Ft - Forint</option><option value="franc" id="element_money_franc" >CHF - Francs</option><option value="koruna" id="element_money_koruna" >Kč - Koruna</option><option value="krona" id="element_money_krona" >kr - Krona</option><option value="pesos" id="element_money_pesos" >$ - Pesos</option><option value="rand" id="element_money_rand" >R - Rand</option><option value="reais" id="element_money_reais" >R$ - Reais</option><option value="ringgit" id="element_money_ringgit" >RM - Ringgit</option><option value="rupees" id="element_money_rupees" >Rs - Rupees</option><option value="zloty" id="element_money_zloty" >zł - Złoty</option><option value="riyals" id="element_money_riyals" >﷼ - Riyals</option></select><script>for(var i=0;i<document.getElementById("currencyID").options.length;i++){document.getElementById("currencyID").options.item(i).innerHTML=EFBP_getCurrencySymbol(document.getElementById("currencyID").options.item(i).value)+" "+EFBP_getCurrencyFirst(document.getElementById("currencyID").options.item(i).value);}</script>';
}
return __p
};
 // currency ends
 
 // Currency function for slider
this["Formbuilder"]["templates"]["edit/currencyslider"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {  
__p += '<div class=\'fb-edit-section-header\'>Currency</div>\n<select id="currencyID"    class="form-control"  data-rv-value="model.' +
((__t = ( Formbuilder.options.mappings.CURRENCY_SLIDER)) == null ? '' : __t) +'"><option value="dollar" id="element_money_usd" ></option><option value="euro" id="element_money_euro" >€ - Euros</option><option value="pound" id="element_money_pound" >£ - Pounds Sterling</option><option value="yen" id="element_money_yen">¥ - Yen</option><option value="baht" id="element_money_baht"  >฿ - Baht</option><option value="forint" id="element_money_forint" >Ft - Forint</option><option value="franc" id="element_money_franc" >CHF - Francs</option><option value="koruna" id="element_money_koruna" >Kč - Koruna</option><option value="krona" id="element_money_krona" >kr - Krona</option><option value="pesos" id="element_money_pesos" >$ - Pesos</option><option value="rand" id="element_money_rand" >R - Rand</option><option value="reais" id="element_money_reais" >R$ - Reais</option><option value="ringgit" id="element_money_ringgit" >RM - Ringgit</option><option value="rupees" id="element_money_rupees" >Rs - Rupees</option><option value="zloty" id="element_money_zloty" >zł - Złoty</option><option value="riyals" id="element_money_riyals" >﷼ - Riyals</option></select><script>for(var i=0;i<document.getElementById("currencyID").options.length;i++){document.getElementById("currencyID").options.item(i).innerHTML=EFBP_getCurrencySymbol(document.getElementById("currencyID").options.item(i).value)+" "+EFBP_getCurrencyFirst(document.getElementById("currencyID").options.item(i).value);}</script>';

}
return __p
};
 // currency  slider ends
 
this["Formbuilder"]["templates"]["edit/defaultvaluephoneinternational"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p += '<div class="hide_domestic" style="display:none; "><div class=\'fb-edit-section-header\'>International No</div>\n\n###\n<input maxlength="3" type="text" data-rv-input="model.' +
((__t = ( Formbuilder.options.mappings.DEFAULT_VALUE_PHONE_INTERNATIONAL1 )) == null ? '' : __t) +
'" style="width: 50px" />\n###\n<input maxlength="3" type="text" data-rv-input="model.' +
((__t = ( Formbuilder.options.mappings.DEFAULT_VALUE_PHONE_INTERNATIONAL2 )) == null ? '' : __t) +
'" style="width: 50px" />\n####\n<input maxlength="4" type="text" data-rv-value="model.' +
((__t = ( Formbuilder.options.mappings.DEFAULT_VALUE_PHONE_INTERNATIONAL3 )) == null ? '' : __t) +
'" style="width: 70px;" /></div>\n  \n';
}
return __p
};

this["Formbuilder"]["templates"]["edit/defaultvaluephone"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p += '<div class="default_value_international"><div class=\'fb-edit-section-header\'>Default Value</div>\n<input  style=\"width:200px;\"  class="form-control" type=\"text\" data-rv-value="model.' +
((__t = ( Formbuilder.options.mappings.DEFAULT_VALUE_PHONE )) == null ? '' : __t) +
'"/></div>\n';
}
return __p
};



this["Formbuilder"]["templates"]["edit/size"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p += '<div class=\'fb-edit-section-header\' >Size</div>\n<select style=\"width:100px;\" class="form-control" data-rv-value="model.' +
((__t = ( Formbuilder.options.mappings.SIZE )) == null ? '' : __t) +
'">\n  <option value="small">Small</option>\n  <option value="medium">Medium</option>\n  <option value="large">Large</option>\n</select>\n';

}
return __p
};

// Address
this["Formbuilder"]["templates"]["edit/address"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {  
__p += '<div class=\'fb-edit-section-header\'>Field address line 2</div>\n<select class="form-control" onChange=\"if(this.options[this.selectedIndex].value==\'checked\'){  Formbuilder.options.mappings.SELECTED_ADDRESS=\'checked\';}else { Formbuilder.options.mappings.SELECTED_ADDRESS=\'unchecked\';} \" data-rv-value="model.' +
((__t = ( Formbuilder.options.mappings.ADDRESS )) == null ? '' : __t) +
'"><option value="checked" selected> Show Address Line 2</option><option value=\'unchecked\'> Hide Address Line 2</option></select>\n';

}
return __p
};
// Address

/* Name */
   this["Formbuilder"]["templates"]["edit/name"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
  
__p += '<div class=\'fb-edit-section-header\'>Field name</div>\n<select id =\"drop_dwn_name\"onChange=\"if(this.options[this.selectedIndex].innerHTML==\'Normal\'){Formbuilder.options.mappings.SELECTED_NAME=\'Normal\';}else if(this.options[this.selectedIndex].innerHTML==\'Normal_Title\'){Formbuilder.options.mappings.SELECTED_NAME=\'Nor_title\';}else if(this.options[this.selectedIndex].innerHTML==\'Full\'){Formbuilder.options.mappings.SELECTED_NAME=\'Full\';}else{Formbuilder.options.mappings.SELECTED_NAME=\'F_title\';}\" data-rv-value="model.' +
((__t = ( Formbuilder.options.mappings.NAME )) == null ? '' : __t) +
'">\n  <option value="Normal">Normal</option>\n  <option value="Nor_title">Normal_Title</option>\n<option value="Full">Full</option>\n<option value="F_title">Full_Title</option> </select>';
}
return __p
}; 

/* Name ends */



this["Formbuilder"]["templates"]["edit/defaultvaluefirst"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p += '<div class=\'fb-edit-section-header\'>First Name</div>\n<input type=\'text\'  data-rv-value="model.' +
((t = ( Formbuilder.options.mappings.DEFAULT_VALUE_FIRST_NM )) == null ? '' : t) +
'">\n';
}
return __p
};


this["Formbuilder"]["templates"]["edit/defaultvaluelast"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p += '<div class=\'fb-edit-section-header\'>Last Name</div>\n<input class="form-control" type=\'text\'  data-rv-value="model.' +
((t = ( Formbuilder.options.mappings.DEFAULT_VALUE_LAST_NM )) == null ? '' : t) +
'">\n';
}
return __p
};


this["Formbuilder"]["templates"]["edit/units"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p += '<div class=\'fb-edit-section-header\'>Units</div>\n<input  style=\"width:200px;\" class="form-control" type="text" data-rv-input="model.' +
((__t = ( Formbuilder.options.mappings.UNITS )) == null ? '' : __t) +
'" />\n';

}
return __p
};

this["Formbuilder"]["templates"]["page"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p +=
((__t = ( Formbuilder.templates['partials/save_button']() )) == null ? '' : __t) +
'\n' +
((__t = ( Formbuilder.templates['partials/left_side']() )) == null ? '' : __t) +
'\n' +
((__t = ( Formbuilder.templates['partials/right_side']() )) == null ? '' : __t) +
'\n<div class=\'fb-clear\'></div>';

}
return __p
};

this["Formbuilder"]["templates"]["partials/add_field"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape, __j = Array.prototype.join;
function print() { __p += __j.call(arguments, '') }
with (obj) {
__p += '<div class=\'fb-tab-pane active\' id=\'addField\'>\n  <div class=\'fb-add-field-types\'>\n    <div class=\'section\'>\n      ';
 _.each(_.sortBy(Formbuilder.inputFields, 'order'), function(f){ ;
__p += '\n        <a data-field-type="' +
((__t = ( f.field_type )) == null ? '' : __t) +
'" class="' +
((__t = ( Formbuilder.options.BUTTON_CLASS )) == null ? '' : __t) +
'">\n          ' +
((__t = ( f.addButton )) == null ? '' : __t) +
'\n        </a>\n      ';
 }); ;
__p += '\n    </div>\n\n    <div class=\'section\'>\n      ';
 _.each(_.sortBy(Formbuilder.nonInputFields, 'order'), function(f){ ;
__p += '\n        <a data-field-type="' +
((__t = ( f.field_type )) == null ? '' : __t) +
'" class="' +
((__t = ( Formbuilder.options.BUTTON_CLASS )) == null ? '' : __t) +
'">\n          ' +
((__t = ( f.addButton )) == null ? '' : __t) +
'\n        </a>\n      ';
 }); ;
__p += '\n    </div>\n  </div>\n</div>\n';

}
return __p
};

this["Formbuilder"]["templates"]["partials/edit_field"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p += '<div class=\'fb-tab-pane\' id=\'editField\'>\n  <div class=\'fb-edit-field-wrapper\'></div>\n</div>\n';

}
return __p
};

this["Formbuilder"]["templates"]["partials/left_side"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p += '<div class=\'fb-left col-md-4 col-sm-4\'>\n  <ul class=\'fb-tabs\'>\n    <li class=\'active\'><a data-target=\'#addField\'>Add a Field</a></li>\n    <li><a data-target=\'#editField\'>Field Properties</a></li>\n <li><a data-target=\'#formField\' id=\'onformField\'>Form Properties</a></li>\n  </ul>\n\n  <div class=\'fb-tab-content\'>\n    ' +
((__t = ( Formbuilder.templates['partials/add_field']() )) == null ? '' : __t) +
'\n    ' +
((__t = ( Formbuilder.templates['partials/edit_field']() )) == null ? '' : __t) +
'\n  </div>\n</div>';

}

return __p
};

this["Formbuilder"]["templates"]["partials/right_side"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p += '<div class=\'fb-right col-md-8 col-sm-8\'>\n  <div class=\'fb-no-response-fields\'>No response fields</div>\n <div class=\'fb-response-form\' id=\'fb-response-formid\'><div id="setformTitle"></div><div id="setformDesc"></div> <input type="hidden" value="" id="submitconfirm"><input type="hidden" name="includejs" value="" id="includejs">  </div>\n  <div class=\'fb-response-fields\'></div>\n</div>\n';

}
return __p
};

this["Formbuilder"]["templates"]["partials/save_button"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p += '<div><div class=\'fb-save-wrapper\'>\n  <button class=\'js-save-form ' +
((__t = ( Formbuilder.options.BUTTON_CLASS )) == null ? '' : __t) +
'\'></button>\n </div><div class="AllButtons"><input type="button" class="view-button" data-toggle="modal" data-target="#myModal" onclick="renderForm();" value="Render" id="rendererButton" style="float:right;"> <input type="button" class="view-button"  onclick="EFBP_send_json_data(form_id,payLoadData,elemntObj,Formjson);" value="Publish" ><input type="button" class="view-button"  onclick="closeFormBox();" value="Close" ></div></div>';

}
return __p
};

this["Formbuilder"]["templates"]["view/base"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p += '<div class=\'subtemplate-wrapper\'>\n  <div class=\'cover\'></div>\n  ' +
((__t = ( Formbuilder.templates['view/label']({rf: rf}) )) == null ? '' : __t) +
'\n\n  ' +
((__t = ( Formbuilder.fields[rf.get(Formbuilder.options.mappings.FIELD_TYPE)].view({rf: rf}) )) == null ? '' : __t) +
'\n\n  ' +
((__t = ( Formbuilder.templates['view/description']({rf: rf}) )) == null ? '' : __t) +
'\n  ' +
((__t = ( Formbuilder.templates['view/duplicate_remove']({rf: rf}) )) == null ? '' : __t) +
'\n</div>\n';

}
return __p
};

this["Formbuilder"]["templates"]["view/base_non_input"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p += '';

}
return __p
};

this["Formbuilder"]["templates"]["view/description"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p += '<span class=\'help-block\'>\n  ' +
((__t = ( Formbuilder.helpers.simple_format(rf.get(Formbuilder.options.mappings.DESCRIPTION)) )) == null ? '' : __t) +
'\n</span>\n';

}
return __p
};

this["Formbuilder"]["templates"]["view/duplicate_remove"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p += '<div class=\'actions-wrapper\'>\n  <a class="js-duplicate ' +
((__t = ( Formbuilder.options.BUTTON_CLASS )) == null ? '' : __t) +
'" title="Duplicate Field"><i class=\'fa fa-plus-circle\'></i></a>\n  <a class="js-clear ' +
((__t = ( Formbuilder.options.BUTTON_CLASS )) == null ? '' : __t) +
'" title="Remove Field"><i class=\'fa fa-minus-circle\'></i></a>\n</div>';

}
return __p
};


this["Formbuilder"]["templates"]["view/label"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape, __j = Array.prototype.join;


function print() { __p += __j.call(arguments, '') }
with (obj) {
__p += '<label>\n  <span>' +
((__t = ( Formbuilder.helpers.simple_format(rf.get(Formbuilder.options.mappings.LABEL)) )) == null ? '' : __t) +
'\n  ';
 if (rf.get(Formbuilder.options.mappings.REQUIRED)) { ;
__p += '\n    <abbr title=\'required\'>*</abbr>\n  ';
 } ;
__p += '\n</label>\n';

}
return __p
};

function EFBP_send_json_data(form_id,payLoadData,elemntObj,Formjson)
	{   	alert('Your form is published.');
		//alert('called');
		var Formjson='{"forms":[{"field_options":{"form_title":"'+$("#setformTitle label").html()+'","form_description":"'+$("#setformDesc label").html()+'","submitconfirm":"'+$("#form_success_message").val()+'","redirecturl":"'+$("#form_redirect_url").val()+'","includejs":"'+$("#includejs").val()+'"}}]}';
		//alert(Formjson);
		if(jQuery.isEmptyObject(elemntObj)){
			  elemntObj='{\"rule1\":[]}';
			  elemntObj=JSON.parse(elemntObj);
		}
		// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
			  $.ajax({
							type: "POST",
							url: ajaxurl,
							data:'form_id='+form_id+'&json_data='+JSON.stringify(payLoadData).replace(/\\/g, '').slice(1, -1)+'&json_logic_data='+JSON.stringify(elemntObj)+'&json_properties_data='+JSON.stringify(JSON.parse(Formjson))+'&action=EFBP_form_json_data',
							function(response) {
							
			getAllForms();				
		}});				
}
		
function EFBP_callslider(min_val,max_val){
min_val=0;
max_val=100;
var elID=$(".editing").attr("id");
var $slider = $(".slider"); 


console.log(' Slider ID '+elID+ ".slider");

$slider.slider({ range:true, min:parseInt(min_val),max:parseInt(max_val), step:1,  values:[parseInt(min_val), parseInt(min_val)], slide:function(event,ui){ $(' .editing .textcurrency').html("<input  id='input' type='text' value='"+ui.value+"'>");} });
}

function EFBP_getCurrencyFirst(x){
var K = ""; var P = ""; var N = ""; if (x == "dollar" || x == "") { K = "&#36;"; P = "Dollars"; N = "Cents" } else { if (x == "euro") { K = "&#8364;"; P = "Euros"; N = "Cents" } else { if (x == "pound") { K = "&#163;"; P = "Pounds"; N = "Pence" } else { if (x == "baht") { K = "&#3647;"; P = "Baht"; N = "Satang" } else { if (x == "rupees") { K = "Rs"; P = "Rupees"; N = "Paise" } else { if (x == "rand") { K = "R"; P = "Rand"; N = "Cents" } else { if (x == "reais") { K = "R&#36;"; P = "Reais"; N = "Centavos" } else { if (x == "forint") { K = "&#70;&#116;"; P = "Forint"; N = "Filler" } else { if (x == "franc") { K = "CHF"; P = "Francs"; N = "Rappen" } else { if (x == "koruna") { K = "&#75;&#269;"; P = "Koruna"; N = "HalÃ©Å™Å¯" } else { if (x == "krona") { K = "kr"; P = "Kroner"; N = "Ã˜re" } else { if (x == "pesos") { K = "&#36;"; P = "Pesos"; N = "Cents" } else { if (x == "ringgit") { K = "RM"; P = "Ringgit"; N = "Sen" } else { if (x == "zloty") { K = "&#122;&#322;"; P = "Zloty"; N = "Grosz" } else { 
if (x == "riyals") { K = "&#65020;"; P = "Riyals"; N = "Halalah" }
else { if (x == "yen") { K = "&#165;"; P = "Yen"}}}}}}}}}}}}}}}}
return P; 
}

function EFBP_getCurrencySecond(x){
var K = ""; var P = ""; var N = ""; if (x == "dollar" || x == "") { K = "&#36;"; P = "Dollars"; N = "Cents" } else { if (x == "euro") { K = "&#8364;"; P = "Euros"; N = "Cents" } else { if (x == "pound") { K = "&#163;"; P = "Pounds"; N = "Pence" } else { if (x == "baht") { K = "&#3647;"; P = "Baht"; N = "Satang" } else { if (x == "rupees") { K = "Rs"; P = "Rupees"; N = "Paise" } else { if (x == "rand") { K = "R"; P = "Rand"; N = "Cents" } else { if (x == "reais") { K = "R&#36;"; P = "Reais"; N = "Centavos" } else { if (x == "forint") { K = "&#70;&#116;"; P = "Forint"; N = "Filler" } else { if (x == "franc") { K = "CHF"; P = "Francs"; N = "Rappen" } else { if (x == "koruna") { K = "&#75;&#269;"; P = "Koruna"; N = "HalÃ©Å™Å¯" } else { if (x == "krona") { K = "kr"; P = "Kroner"; N = "Ã˜re" } else { if (x == "pesos") { K = "&#36;"; P = "Pesos"; N = "Cents" } else { if (x == "ringgit") { K = "RM"; P = "Ringgit"; N = "Sen" } else { if (x == "zloty") { K = "&#122;&#322;"; P = "Zloty"; N = "Grosz" } else { 
if (x == "riyals") { K = "&#65020;"; P = "Riyals"; N = "Halalah" }
else { if (x == "yen") { K = "&#165;"; P = "Yen"}}}}}}}}}}}}}}}}
return N; 
}
  
function EFBP_getCurrencySymbol(x){
var K = ""; var P = ""; var N = ""; if (x == "dollar" || x == "") { K = "&#36;"; P = "Dollars"; N = "Cents" } else { if (x == "euro") { K = "&#8364;"; P = "Euros"; N = "Cents" } else { if (x == "pound") { K = "&#163;"; P = "Pounds"; N = "Pence" } else { if (x == "baht") { K = "&#3647;"; P = "Baht"; N = "Satang" } else { if (x == "rupees") { K = "Rs"; P = "Rupees"; N = "Paise" } else { if (x == "rand") { K = "R"; P = "Rand"; N = "Cents" } else { if (x == "reais") { K = "R&#36;"; P = "Reais"; N = "Centavos" } else { if (x == "forint") { K = "&#70;&#116;"; P = "Forint"; N = "Filler" } else { if (x == "franc") { K = "CHF"; P = "Francs"; N = "Rappen" } else { if (x == "koruna") { K = "&#75;&#269;"; P = "Koruna"; N = "HalÃ©Å™Å¯" } else { if (x == "krona") { K = "kr"; P = "Kroner"; N = "Ã˜re" } else { if (x == "pesos") { K = "&#36;"; P = "Pesos"; N = "Cents" } else { if (x == "ringgit") { K = "RM"; P = "Ringgit"; N = "Sen" } else { if (x == "zloty") { K = "&#122;&#322;"; P = "Zloty"; N = "Grosz" } else { 
if (x == "riyals") { K = "&#65020;"; P = "Riyals"; N = "Halalah" }
else { if (x == "yen") { K = "&#165;"; P = "Yen"}}}}}}}}}}}}}}}}
return K; 
}