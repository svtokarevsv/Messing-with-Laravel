function confirmArchive(){
    if (confirm("Вы действительно хотите переместить это объявление в архив?")){
        return true;
    }else {
        return false;
    }
}
function confirmDelete(){
    if (confirm("Вы действительно хотите удалить аккаунт?")){
        return true;
    }else {
        return false;
    }
}