<span id="span_left_menu">
<?

if(eqyn(get_admin_auth(), "A")){
	$sql = "
		select *
		from tb_admin_memu as tb1
		where amm_status = 'Y'
		order by amm_seq asc
	";
}else{
	
	$now_id = get_admin();

	$sql = "
		select
			*
		from tb_admin_memu as tb1
		where amm_status = 'Y'
		  and 
			(
			  amm_key in (
				select fk_ama_amm_key from tb_admin_mem_auth where fk_ama_am_userid = '$now_id'
			  )    
			  or
			  amm_key in(
				  select
					fk_amm_amm_key
				  from tb_admin_memu
				  where amm_key in (
					select fk_ama_amm_key from tb_admin_mem_auth where fk_ama_am_userid = '$now_id'
				  )
			  )
			)
		order by amm_seq asc
	";
}
//echo $sql;
$row = sql_array($sql);

if($row){
	foreach($row as &$value){
//		echo $value[amm_fname];


		if(eqyn($value[fk_amm_amm_key], "-")){
?>
			<div class="menu_title<? if(strpos( $GLB_SELFPAGE, $value[amm_fname])) {echo " menu_title_bold";} ?>">
<?
				if(!eqyn($value[amm_link], "")){
?>
					<a href="<?= $admin_dir . $value[amm_link] ?>"><?= $value[amm_name] ?></a>
<?
				}else{
					echo $value[amm_name];
				}
?>
			</div>
<?
		}else{
?>
			<div class="dowon">
				<a href="<?= $admin_dir . $value[amm_link] ?>" class="<? if(strpos( $GLB_SELFPAGE, $value[amm_fname])) {echo " menu_title_bold";} ?>">- <?= $value[amm_name] ?></a><br>
			</div>

<?
		}
	}
}
?>
</span>