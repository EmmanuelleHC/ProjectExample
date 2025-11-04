@extends('products.layout')

@section('content')
<div class="container mt-4">
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <div id="toolbar">
        <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newProduct()">Add</a>
        <a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editProduct()">Edit</a>
        <a href="#" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="destroyProduct()">Delete</a>
    </div>

    <table id="dg" title="Product List" class="easyui-datagrid" style="width:100%;height:400px"
        url="{{ route('products.index') }}"  
        method="get"
        toolbar="#toolbar" pagination="true"
        rownumbers="true" fitColumns="true" singleSelect="true">
        <thead>
            <tr>
                <th field="id" width="50">ID</th>
                <th field="name" width="150">Name</th>
                <th field="detail" width="250">Detail</th>
                <th field="price" width="80" align="right">Price</th>
                <th field="stock" width="80" align="center">Stock</th>
                <th field="image" width="100" formatter="formatImage">Image</th>
            </tr>
        </thead>
    </table>

    <div id="dlg" class="easyui-dialog" style="width:400px"
            closed="true" buttons="#dlg-buttons">
        <form id="fm" method="post" enctype="multipart/form-data" novalidate>
            @csrf
            <div class="fitem" style="margin-bottom:10px">
                <label>Name:</label>
                <input name="name" class="easyui-textbox" required="true" style="width:100%">
            </div>
            <div class="fitem" style="margin-bottom:10px">
                <label>Detail:</label>
                <input name="detail" class="easyui-textbox" multiline="true" style="width:100%;height:60px">
            </div>
            <div class="fitem" style="margin-bottom:10px">
                <label>Price:</label>
                <input name="price" class="easyui-numberbox" required="true" style="width:100%" data-options="precision:2,groupSeparator:','">
            </div>
            <div class="fitem" style="margin-bottom:10px">
                <label>Stock:</label>
                <input name="stock" class="easyui-numberbox" required="true" style="width:100%">
            </div>
            <div class="fitem" style="margin-bottom:10px">
                <label>Image:</label>
                <input name="image" class="easyui-filebox" style="width:100%">
            </div>

        </form>
    </div>

    <div id="dlg-buttons">
        <a href="#" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveProduct()" style="width:90px">Save</a>
        <a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="$('#dlg').dialog('close')" style="width:90px">Cancel</a>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://www.jeasyui.com/easyui/themes/default/easyui.css">
<link rel="stylesheet" type="text/css" href="https://www.jeasyui.com/easyui/themes/icon.css">
<script type="text/javascript" src="https://www.jeasyui.com/easyui/jquery.easyui.min.js"></script>
<script type="text/javascript">
var url = null; // global URL for saveProduct()

// Formatter to display images in datagrid
function formatImage(value,row,index){
    if(value){
        return '<img src="/storage/'+value+'" width="50" />';
    }
    return '';
}

// Open dialog for creating new product
function newProduct() {
    $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Add New Product');
    $('#fm')[0].reset();  // clear all inputs
    url = "{{ route('products.store') }}"; // POST URL
}

// Open dialog for editing selected product
function editProduct() {
    var row = $('#dg').datagrid('getSelected');
    if (row) {
        $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Edit Product');
        // Load row data into form
        $('#fm')[0].reset();
        for (let key in row) {
            if($('#fm [name="'+key+'"]').length){
                $('#fm [name="'+key+'"]').val(row[key]);
            }
        }
        url = "/products/" + row.id; // PUT URL
    } else {
        $.messager.alert('Warning', 'Please select a product first!');
    }
}

// Save product (create or update)
function saveProduct() {
    if(!url){
        $.messager.alert('Error', 'Please open the form using Add or Edit.');
        return;
    }

    var formElement = document.getElementById('fm');
    var formData = new FormData(formElement);

    // If editing, append _method=PUT
    if(url !== "{{ route('products.store') }}"){
        formData.append('_method', 'PUT');
    }

    $.ajax({
        url: url,
        type: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        data: formData,
        processData: false,
        contentType: false,
        success: function (result) {
            $('#dlg').dialog('close');
            $('#dg').datagrid('reload');
            $.messager.show({ title: 'Success', msg: result.message || 'Product saved successfully!' });
        },
        error: function (xhr) {
            let msg = xhr.responseJSON?.message || 'Failed to save product.';
            $.messager.alert('Error', msg);
        }
    });
}

// Delete selected product
function destroyProduct() {
    var row = $('#dg').datagrid('getSelected');
    if (row) {
        $.messager.confirm('Confirm', 'Are you sure you want to delete this product?', function (r) {
            if (r) {
                $.ajax({
                    url: "/products/" + row.id,
                    type: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
                    success: function (result) {
                        $('#dg').datagrid('reload');
                        $.messager.show({ title: 'Success', msg: result.message || 'Product deleted successfully!' });
                    },
                    error: function () {
                        $.messager.alert('Error', 'Failed to delete product.');
                    }
                });
            }
        });
    } else {
        $.messager.alert('Warning', 'Please select a product first!');
    }
}

</script>
@endsection
