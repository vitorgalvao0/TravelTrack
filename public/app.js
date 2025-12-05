document.addEventListener('DOMContentLoaded', function(){
  const logoutBtn = document.getElementById('logoutBtn');
  if (logoutBtn) {
    logoutBtn.addEventListener('click', function(e){
      e.preventDefault();
      fetch('index.php?page=auth&action=logout',{method:'POST'}).catch(()=>location.href='index.php?page=login');
      location.href='index.php?page=login';
    });
  }
});
