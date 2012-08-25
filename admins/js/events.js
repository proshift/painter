
var news = new function() {

	var that = this

	this.addNews = function() {
		$("#addForm").submit()
	}

	this.openAddModal = function() {
		$("#addModal .btn-primary").text("Add")
		$("#addModal h3").text("Add a News")
		$("#addModal input[name=title]").val("")
		$("#addModal textarea").val("")
		$("#addModal input[type=hidden]").val("add")
	}

	this.openEditModal = function(id, index) {
		record = $("#wrapper tr:eq("+index+")")
		$("#addModal .btn-primary").text("Edit")
		$("#addModal h3").text("Edit a News")
		$("#addModal input[type=hidden]").val("edit")
		$("#addModal input[name=id]").val(id)
		$("#addModal input[name=title]").val( record.children("td:eq(0)").text() )
		$("#addModal textarea").val( record.children("td:eq(1)").text() )
	}

	this.deleteNews = function() {
		$("#deleteForm").submit()
	}

	this.openDeleteBox = function(id, index) {
		$("#deleteBox input[name=id]").val(id)
	}
}


$( function() {
	$(".datepicker").datepicker()
})