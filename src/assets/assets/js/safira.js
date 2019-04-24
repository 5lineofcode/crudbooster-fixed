var onEditViewMode = null;
var onAddViewMode = null;
var onDetailViewMode = null;
var onListViewMode = null;

if (window.location.href.indexOf("/add?") > -1) {
	onAddViewMode = true;
}

else if (window.location.href.indexOf("/edit/") > -1) {
	onEditViewMode = true;
}

else if (window.location.href.indexOf("/detail/") > -1) {
	onDetailViewMode = true;
}

else {
	onListViewMode = true;
}