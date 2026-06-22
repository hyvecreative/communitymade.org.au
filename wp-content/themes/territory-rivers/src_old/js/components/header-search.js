'use strict';
const IS_ACTIVE_CLASS = 'header-search-is-active';

export default class HeaderSearch {
  constructor() {
    this.$search = $('.header-search');
    this.$searchField = this.$search.find('.header-search-field');
    this.$submitBtn = this.$search.find('.header-search-submit');
    this.$resetBtn = this.$search.find('.header-search-reset');
    this.state = { active: false };
  }

  init() {
    this.setupSubmitBtn();
    this.setupClickOffToClose();

    this.$search.on('keyup', (e) => e.which === 27 && this.blur());
    // Causes issue that prevents search button from executing
    // search when input is active
    // this.$searchField.on('blur', () => this.blur());
    this.$resetBtn.on('click', () => this.blur());

  }

  focus() {
    this.$search.addClass(IS_ACTIVE_CLASS);
    this.$submitBtn.prop('type', 'submit');
    setTimeout(() => {
      this.setupClickOffToClose();
      this.$searchField.focus();
    }, 20);
    this.state.active = true;
  }

  blur() {
    $('body').off('click.headerSearch');
    this.$search.removeClass(IS_ACTIVE_CLASS);
    this.$submitBtn.prop('type', 'button');
    this.state.active = false;
  }

  setupSubmitBtn() {

    this.$submitBtn.on('click', (e) => {
      if (!this.state.active) {
        this.focus();
        e.preventDefault();
      }
    });
  }

  setupClickOffToClose() {

    $('body').on('click.headerSearch', (e) => {
      if (!$(e.target).closest('.header-search').length) {
        this.blur();
      }
    });
  }
}
