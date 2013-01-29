/**
 * version: 0.2.5
 */

(function( $, undefined ) {
$.widget( 'ui.citrusform', {
  _create: function (){
    var $body = $('body'),
        self = this;
      
    //Check for placeholder support
    this._pholderSupport =  !!("placeholder" in document.createElement( "input" ));
    //Check form HTML5 validation support
    this._validationSupport = ((typeof document.createElement("input").validity != 'undefined') &&
                                (typeof document.createElement('form').checkValidity() != 'undefined'));
    
    //If no placeholder support attach event listeners so we can mimic the behaviour
    if(!this._pholderSupport){
      this._pholderShim();
    }
    
    this.element.keyup(function(evt){
        self.element.addClass('focus');
    });
 
    if(!this._validationSupport){
      this._validationShim();
    }
    
    $('<div/>').addClass(this.options.errorContainer)
      .prependTo(this.element);

    // this.element.submit(function(){return false;});
    this.element.submit(function(evt){
      evt.preventDefault();
       if(!this._pholderSupport){
        $('#' + $(this).attr('id') + ' [placeholder]').each(function(i,el){
          if($(el).attr('placeholder') == $(el).val())
            $(el).val('');
        });
      }
	
      console.log('submitting');
      //if the form is invalid prevent submission and display errors
      if(!self.checkValidity()){
        this.element.find('.cico-thanks, .contact-error').remove();
        return;
      }
        
      var req = $(this).serialize() + '&action=' + CiCo.action;
      console.log(req);
      $.ajax({
        url: CiCo.ajaxurl,
        type: "POST",
        data: req,
        dataType: 'json',
        success: function(response){
          $('.cico-thanks, .contact-error').remove();
          self._trigger('ajaxsuccess');

          if (response.success){
            $('<p class="cico-thanks">Thank you for getting in contact with us. We\'ll be in touch shortly.</p>')
              .prependTo(self.element);

            self.element.find('textarea, input[type!="hidden"]')
              .val('')
              .addClass('invalid')
              .removeClass('valid');

            if(!self._pholderSupport){
              self._showPholder();
            }
            return;
          }
          
          if(response.errors.contactName != null){
            self._displayError($('#name'), response.errors.contactName);
          }
          if(response.errors.email != null){
            self._displayError($('#email'), response.errors.email);
          }
          if(response.errors.comments != null){
            self._displayError($('#enquiry'), response.errors.comments);
          }
        }
      });
    });
  },
  _init: function() { },
  _checkElValidity: function(evt){
    var el = evt;
    if(this._validationSupport)
      return el.get(0).validity.valid;
    
    if(el.data('validity') === undefined)
      el.data('validity', {valid:false});
    
    //We have to use natve JS getAttribute as the jQuery implementation retrives this
    //value from the DOM which sets all unsupported input types to 'text'
    if(el.get(0).nodeName == 'TEXTAREA' || (el.get(0).nodeName == 'INPUT' && el.get(0).getAttribute('type')=='text')){
      //If its a textarea and not required make field valid and return value
      if(el.attr('required') == undefined){
          return el.removeClass('invalid').addClass('valid').data('validity').valid = true;
      }else{
        //If required makesure field is not empty or it's contents are not the same
        //as the placeholder value
        if(el.val() != '' && el.val() != el.attr('placeholder')){
          return el.removeClass('invalid').addClass('valid').data('validity').valid = true;
        }else{
          $label = this.element.find('[for='+ el.attr('id') +']');
          el.data('validity').errorMsg = 'You forgot to enter "' + $label.text() + '"';
          return el.removeClass('valid').addClass('invalid').data('validity').valid = false;
        }
      }
    }
    if(el.get(0).nodeName == 'INPUT'){
      switch(el.get(0).getAttribute('type')){
        case 'email':
          if (this._emailPattern.test(el.val()) && el.val() != el.attr('placeholder')){
            el.removeClass('invalid').addClass('valid').data('validity').valid = true;
          }else{
            el.data('validity').errorMsg = 'You entered an incorrect email address';
            el.removeClass('valid').addClass('invalid').data('validity').valid = false;
          }
        break;
        
        case 'url':
          if (this._urlPattern.test(el.val()) && el.val() != el.attr('placeholder')){
            el.removeClass('invalid').addClass('valid').data('validity').valid = true;
          } else{
            el.data('validity').errorMsg = 'You entered an incorrect URL';
            el.removeClass('valid').addClass('invalid').data('validity').valid = false;
          }
        break;
        deafult:
        break;
      }
    }
    return el.data('validity').valid;
  },
  checkValidity: function (){
    var self = this;

    this.element
      .find('.contact-thanks, .contact-error')
      .remove();
    if(this._validationSupport)
      return this.element.get(0).checkValidity();
    
    var validForm = true;
    this.element.find('input, textarea').each(function(i, el){
      if(!$(el).data('validity').valid && $(el).attr('type') != 'hidden' ){
        validForm = false;
        console.log($(el));
        self._displayError($(el), $(el).data('validity').errorMsg);
      }
    });
    return validForm;
  },
  _displayError: function (el, msg){
    $errorEl = this.element.find(this.options.errorContainer);
    $('<span/>').addClass('contact-error')
      .text(msg)
      .appendTo($errorEl);
  },
  _pholderShim: function(){
    var self = this;

    this._showPholder();
      
    this.element.find("[placeholder]")
      .focusin(function(){
        var phvalue = $(this).attr("placeholder");
        if (phvalue == $(this).val()) {
          $(this).val("");
        }
      }).focusout(function(){
        var phvalue = $(this).attr("placeholder");
        if ($(this).val() == "") {
          $(this).val(phvalue);
        }
        self._checkElValidity($(this));
      });
  },
  _validationShim: function(){
    var self = this;
    this.element.find('input, textarea')
      .each(function(i, el){
        self._checkElValidity($(el));
        if($(el).attr('required') != undefined)
          $(el).addClass('required');
      });
      
    this.element.keyup(function(evt){
      //We need to use the evt.target property as we are listening to events
      //on the whole form
      self._checkElValidity($(evt.target));
    });
  },
  _showPholder: function(){
    this.element.find('[placeholder]').each(function(i, el){
      var phvalue = $(this).attr("placeholder");
      $(this).val($(this).attr('placeholder'));
    });
  },
  _pholderSupport: false,
  _validationSupport: false,
  _emailPattern: new RegExp("^([a-z0-9_.-]+)@([0-9a-z.-]+).([a-z.]{2,6})$","i"),
  _urlPattern: new RegExp("[a-z][-\.+a-z]*:\/\/","i"),
  off: function() {
    this.destroy(); // use the predefined function
  },
  options: {
    requiredClass: 'required',
    invalidClass: 'invalid',
    validClass: 'valid',
    errorContainer: '.err-box',
    submitClass: '.cico-submit'
  }
});

$.extend( $.ui.citrusform, {
  version: "0.1"
});
})( jQuery );

jQuery(document).ready(function($) {
  $(CiCo.formSelector).citrusform();
});
