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
            </tr>
        </thead>
    </table>

    <div id="dlg" class="easyui-dialog" style="width:400px"
            closed="true" buttons="#dlg-buttons">
        <form id="fm" method="post" novalidate>
            @csrf
            <div class="fitem" style="margin-bottom:10px">
                <label>Name:</label>
                <input name="name" class="easyui-textbox" required="true" style="width:100%">
            </div>
            <div class="fitem">
                <label>Detail:</label>
                <input name="detail" class="easyui-textbox" multiline="true" style="width:100%;height:60px">
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
var url;

function newProduct() {
    $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'New Product');
    $('#fm').form('clear');
    url = "{{ route('products.store') }}";
}

function editProduct() {
    var row = $('#dg').datagrid('getSelected');
    if (row) {
        $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Edit Product');
        $('#fm').form('load', row);
        url = "/products/" + row.id; 
    } else {
        $.messager.alert('Warning', 'Please select a product first!');
    }
}

function saveProduct() {
    var row = $('#dg').datagrid('getSelected');
    var formData = $('#fm').serializeArray(); 
    var method = url.includes('/products/') ? 'PUT' : 'POST';

    var data = {};
    $.map(formData, function(n, i){
        data[n['name']] = n['value'];
    });

    $.ajax({
        url: url,
        type: method,   
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        data: data,
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
