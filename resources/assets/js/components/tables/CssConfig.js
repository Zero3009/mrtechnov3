export default {
  table: {
    tableClass: 'table table-striped table-responsive="md" table-hover table-bordered show-empty',
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
    activeClass: "btn btn-primary",
    disabledClass: "btn btn-border",
    pageClass: "btn btn-border",
    linkClass: "page-item",
    icons: {
      first: "glyphicon glyphicon-step-backward",
      prev: "glyphicon glyphicon-chevron-left",
      next: "glyphicon glyphicon-chevron-right",
      last: "glyphicon glyphicon-step-forward"
    }
  }
};