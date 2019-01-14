export default {
  table: {
    tableClass: "table responsive striped hover bordered show-empty",
    ascendingIcon: "glyphicon glyphicon-chevron-up",
    descendingIcon: "glyphicon glyphicon-chevron-down",
    handleIcon: "glyphicon glyphicon-menu-hamburger",
    renderIcon: function(classes, options) {
      return `<span class="${classes.join(' ')}"></span>`
    }
  },
  paginationInfo: {
    infoClass: 'pull-left'
  },
  pagination: {
    wrapperClass: "pagination pull-right",
    activeClass: "btn-primary",
    disabledClass: "disabled",
    pageClass: "btn btn-border",
    linkClass: "btn btn-border",
    icons: {
      first: "glyphicon glyphicon-step-backward",
      prev: "glyphicon glyphicon-chevron-left",
      next: "glyphicon glyphicon-chevron-right",
      last: "glyphicon glyphicon-step-forward"
    }
  }
};