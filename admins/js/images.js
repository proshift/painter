
var images = new function() {

	var that = this

	this.addImage = function() {
		$("#addForm").submit()
	}

	this.openAddBox = function() {
		$("#addBox .btn-primary").text("Add")
		$("#addBox h3").text("Add an Image")
		$("#addBox input[name=title]").val("")
		$("#addBox textarea").val("")
		$("#addBox input[type=hidden]").val("add")
	}

	this.openEditModal = function(id, index) {
		var record = $("#wrapper tr:eq("+index+")")
		$("#addBox .btn-primary").text("Edit")
		$("#addBox h3").text("Edit a images")
		$("#addBox input[type=hidden]").val("edit")
		$("#addBox input[name=id]").val(id)
		$("#addBox input[name=title]").val( record.children("td:eq(0)").text() )
		$("#addBox textarea").val( record.children("td:eq(1)").text() )
	}

	this.deleteImage = function() {
		$("#deleteForm").submit()
	}

	this.openDeleteBox = function(id, index) {
		$("#deleteBox input[name=id]").val(id)
	}

	this.retreiveImages = function() {
		$.ajax({
			url : "php/retreiveImages.php",
			type : 'post',
			data : { token : "ozan"},
			success : function(data) {
				//document.write(data)
				var output = ''
				var count = 0
				var imagesArr = $.parseJSON(data)
				for( var key in  imagesArr) {
					var record = imagesArr[key]
					output += '<tr>'
					output += '<td></td>'
					output += '<td>' + record.imagename + '</td>'
					output += '<td style="width:150px;">' + record.imagedesc + '</td>'
			  		output += '<td>' + record.category + '</td>'
			  		output += '<td>' + record.views + '</td>'
			  		output += '<td style="width:150px;">'
			  		output += '<a href="#deleteBox" class="btn btn-danger buttonOpenDelete" data-toggle="modal"><span class="icon-trash icon-white"></span> Delete</a>'
			  		output += '<a href="#addBox" class="btn btn-primary buttonOpenEdit" data-toggle="modal"><span class="icon-edit icon-white"></span> Edit</a>'
			  		output += '</td></tr>'
					$(".buttonOpenDelete").click( function() { images.openDeleteBox(record.id, count) })
					$(".buttonOpenEdit").click( function() { images.openEditModal(record.id, count) })
				 	count++
				 	console.log(output)
				}
			}
		})
	}
}


$( function() {
	$("#buttonOpenAdd").click( function() { images.openAddBox() })
	$("#buttonAddImage").click( function() { images.addImage() })
	$("#buttonDeleteImage").click( function() { images.deleteImage() })
	images.retreiveImages()
})