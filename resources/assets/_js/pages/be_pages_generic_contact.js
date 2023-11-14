/*
 *  Document   : be_pages_generic_contact.js
 *  Author     : pixelcave
 *  Description: Custom JS code used in Contact Page
 */

class pageContact {
  /*
   * Init Contact Form Validation, for more examples you can check out https://github.com/jzaefferer/jquery-validation
   *
   */
  static initValidationContact() {
    // Load default options for jQuery Validation plugin
    Codebase.helpers('jq-validation');

    // Init Form Validation
    jQuery('.js-validation-be-contact').validate({
      rules: {
        'be-contact-name': {
          required: true,
          minlength: 2
        },
        'be-contact-email': {
          required: true,
          emailWithDot: true
        },
        'be-contact-subject': {
          required: true
        },
        'be-contact-message': {
          required: true,
          minlength: 2
        }
      },
      messages: {
        'be-contact-name': 'Please provide at least your first name',
        'be-contact-email': 'Please enter your valid email address to be able to reach you back',
        'be-contact-subject': 'Please select where woul you like to send your message',
        'be-contact-message': 'What would you like to say?'
      }
    });
  }

  /*
   * Init functionality
   *
   */
  static init() {
    this.initValidationContact();
  }
}

// Initialize when page loads
Codebase.onLoad(pageContact.init());
