<div class="thumbnail box-gradient">
	<?
	if($posted=="")$posted=0;
	if($closed=="")$closed=0;
	
	echo link_button('Save', 'save_this()','save');		
	echo link_button('Print', 'print_voucher()','print');		
	echo link_button('Add','','add','false',base_url().'index.php/cash_in/add');		
	echo link_button('Search','','search','false',base_url().'index.php/cash_in');		
	if($mode=="view") echo link_button('Refresh','','reload','false',base_url().'index.php/cash_in/view/'.$voucher);		
	if($mode=="view") echo link_button('Delete','','remove','false',base_url().'index.php/cash_in/delete/'.$voucher);		
	
	if($posted) {
		echo link_button('UnPosting','','cut','false',base_url().'index.php/cash_in/unposting/'.$voucher);		
	} else {
		echo link_button('Posting','','ok','false',base_url().'index.php/cash_in/posting/'.$voucher);		
	}
	echo "<div style='float:right'>";
	echo link_button('Help', 'load_help(\'cash_in\')','help');		
	?>
	<a href="#" class="easyui-splitbutton" data-options="plain:false,menu:'#mmOptions',iconCls:'icon-tip'">Options</a>
	<div id="mmOptions" style="width:200px;">
		<div onclick="load_help('cash_in')">Help</div>
		<div onclick="show_syslog('cash_in','<?=$voucher?>')">Log Aktifitas</div>

		<div>Update</div>
		<div>MaxOn Forum</div>
		<div>About</div>
	</div>
	</div>
</div>

<div class="thumbnail">	

<?php if (validation_errors()) { ?>
	<div class="alert alert-error">
	<button type="button" class="close" data-dismiss="alert">x</button>
	<h4>Terjadi Kesalahan!</h4> 
	<?php echo validation_errors(); ?>
	</div>
<?php } ?>
 <?php if($message!="") { ?>
	<div class="alert alert-success"><? echo $message;?></div>
<? } ?>


<?php 
    if($mode=='view'){
            echo form_open('cash_in/update','id=myform name=myform');
            $disabled='disable';
    } else {
            $disabled='';
            echo form_open('cash_in/save','id=myform name=myform'); 
    }
?>

 <input type='hidden' id='posted' name='posted' value='<?=$posted?>'>    

   <table class='table' width='100%'>
       <tr>
            <td>Jenis Pembayaran</td>
			<td colspan='3'>
                <?php echo form_radio('trans_type','cash in',$trans_type=='cash in'," checked ");?> &nbsp Cash
                &nbsp <?php echo form_radio('trans_type','cheque in',$trans_type=='cheque in');?> &nbsp Giro/Cek
                &nbsp <?php echo form_radio('trans_type','trans in',$trans_type=='trans in');?> &nbsp Transfer
            </td>
       <tr>
       <tr>
            <td>Rekening Penerima </td><td><?php echo form_dropdown( 'account_number',$account_number_list,$account_number,"style='height:30px'");?></td>
            <td>Voucher Kas Masuk</td><td>
			<?php
				echo "<input type='hidden' name='mode' id='mode' value='$mode'>";
			if($mode=='view'){
				echo "<strong>".$voucher."</strong>";
				echo "<input type='hidden' name='voucher' id='voucher' value='$voucher'>";
			} else { 
				echo form_input('voucher',$voucher);
			}		
			?></td>
       </tr>
       <tr>
            <td>Jumlah Terima</td><td><?php echo form_input('deposit_amount',$deposit_amount);?></td>
            <td>Nomor Giro</td><td><?php echo form_input('check_number',$check_number);?></td>
       <tr>
       <tr>
            <td>Tanggal Kas</td>
			<td><?php echo form_input('check_date',$check_date,'id=check_date 
             class="easyui-datetimebox"  style="width:150px;height:30px" 
			 data-options="formatter:format_date,parser:parse_date"');?></td>
            <td colspan='2'>			 
			 &nbsp <?php echo form_checkbox('cleared',$cleared);?> &nbsp Giro Cair
			 &nbsp <?php echo form_checkbox('void',$void);?> Giro Batal
			 </td>
       <tr>
		<tr>
            <td>Penerimaan Piutang</td>
			<td><?php echo form_checkbox('bill_payment',$bill_payment);?></td>
			<td>Tanggal Jth Tempo</td><td><?php echo form_input('cleared_date',$cleared_date,'id=cleared_date 
             class="easyui-datetimebox"   style="width:150px;height:30px" 
			 data-options="formatter:format_date,parser:parse_date"');?></td>
       </tr>
       <tr>
            <td>Penerima/Pelanggan </td><td><?php echo form_input('supplier_number',$supplier_number,"id='sold_to_customer'");?>
			<?=link_button("","select_customer();return false","search");?>
			</td>
            <td>Nomor Transfer </td><td><?php echo form_input('bank_tran_id',$bank_tran_id);?></td>
       </tr>
		<tr>
            <td>Diterima dari</td><td><?php echo form_input('payee',$payee,"id='company'");?></td>
            <td>Bank Pengirim</td><td><?php echo form_input('from_bank',$from_bank);?></td>
		</tr>
       <tr>
            <td>Keterangan</td><td colspan='6'><?php echo form_input('memo',$memo,"style='width:100%'");?></td>
       </tr>
   </table>
 </form>

	<div class="easyui-tabs" >
		<div title="Perkiraan" style="padding:10px">
			<table id="dgItemCoa" class="easyui-datagrid"  width='100%'
				data-options="
					iconCls: 'icon-edit', fitColumns: true,
					singleSelect: true,
					toolbar: '#tb',  
					url: '<?=base_url()?>index.php/cash_in/items/<?=$voucher?>'
				">
				<thead>
					<tr>
						<th data-options="field:'account',editor:'text',width:'80'">Kode Akun</th>
						<th data-options="field:'description',editor:'text',width:'200'">Nama Perkiraan</th>
						<th data-options="field:'amount',width:'80',editor:'text',align:'right'">Amount</th>
						<th data-options="field:'invoice',width:'80',editor:'text'">Invoice</th>
						<th data-options="field:'comments',width:'100',editor:'text'">Comments</th>
						<th data-options="field:'line_number',width:'30'">Line</th>
					</tr>
				</thead>
			</table>
		</div>

		<? 
		$data['gl_id']=$voucher;
		echo load_view("gl/jurnal_view",$data); 
		?> 
	</div>
	

</div>
<div id="tb" style="height:auto">
	<form method='post' id='frmItem'>
	<input type='hidden' id='line_number' name='line_number'>
	<input type='hidden' id='voucher_item' name='voucher_item'>
	<table class='table' width='100%'>
		<thead>
		<tr>
			<td>Kode</td><td>Nama Perkiraan</td><td>Jumlah</td><td>Catatan</td><td>Action</td>
		</tr>
		</thead>
		<tbody><tr>
			<td><input type='text' id='account' name='account' style='width:80px'>
				<?=link_button('','lookup_coa()','search')?></td>
			<td><input type='text' id='description' name='description'></td>
			<td><input type='text' id='amount' name='amount' style='width:80px'></td>
			<td><input type='text' id='comments' name='comments'></td>
			<td><?=link_button('Add Item','save_item()','save')?></td>
			</tr>
		</tbody>
	</table>
	</form>
	<div id="tbItem" class='box-gradient'>
		<a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editItem();return false;">Edit</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="deleteItem(); return false;">Delete</a>	
	</div>
	
</div>

<?=load_view('gl/select_coa')?>
<?=load_view('sales/customer_select')?>

<script type="text/javascript">
    function save_this(){
        if($('#voucher').val()===''){alert('Isi kode voucher !');return false;};
        if($('#trans_type').val()===''){alert('Isi jenis penerimaan !');return false;};
       $('#myform').submit();
    }
	function save_item(){
		var mode=$("#mode").val();
		if(mode=="add"){alert("Simpan dulu bagian header !");return false;}
		
		var url = '<?=base_url()?>index.php/cash_in/save_item';
		console.log(url);
		$('#voucher_item').val($('#voucher').val());
					 
		$('#frmItem').form('submit',{
			url: url,
			onSubmit: function(){
				return $(this).form('validate');
			},
			success: function(result){
				var result = eval('('+result+')');
				if (result.success){
					$('#dgItemCoa').datagrid('reload');
					$('#frmItem').form('clear');
					$('#account').val('');
					$('#description').val('');
					$('#line_number').val('');
					$('#amount').val('0');
					$.messager.show({
						title: 'Success',
						msg:  result.msg
					});
				} else {
					$.messager.show({
						title: 'Error',
						msg: result.msg
					});
				}
			}
		});
	}
	
		function deleteItem(){
			var row = $('#dgItemCoa').datagrid('getSelected');
			if (row){
				$.messager.confirm('Confirm','Are you sure you want to remove this line?',function(r){
					if (r){
						url='<?=base_url()?>index.php/cash_in/delete_item';
						$.post(url,{line_number:row.line_number},function(result){
							if (result.success){
								$('#dgItemCoa').datagrid('reload');	// reload the user data
							} else {
								$.messager.show({	// show error message
									title: 'Error',
									msg: result.msg
								});
							}
						},'json');
					}
				});
			}
		}
		function editItem(){
			var row = $('#dgItemCoa').datagrid('getSelected');
			if (row){
				$('#frmItem').form('load',row);
				$('#account').val(row.account);
				$('#description').val(row.description);
				$('#line_number').val(row.line_number);
				$('#amount').val(row.amount);
			}
		}
	
</script>  
