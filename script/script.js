function delete_check(){
	<?php $flag = FALSE; ?>
	// 「OK」時の処理開始 ＋ 確認ダイアログの表示
	if(window.confirm('削除すると２度と元には戻せません。削除しますか？')){
		<?php $flag = TRUE; ?>
		return <?php $flag;?>
	}
	// 「キャンセル」時の処理開始
	else{
		window.alert('キャンセルされました'); // 警告ダイアログを表示
		<?php $flag = FALSE; ?>
		return <?php $flag; ?>
	}
	// 「キャンセル」時の処理終了
}
