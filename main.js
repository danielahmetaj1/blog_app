const navItems = document.querySelector('.nav__items');
const openNavBtn = document.querySelector('#nav_open-btn');
const closeNavBtn = document.querySelector('#nav_close-btn');
//hapja e nav menu
const openNav= () => {
    navItems.style.display = 'flex';
    openNavBtn.style.display = 'none';
    closeNavBtn.style.display = 'inline-block'; 

}

//mbyllja e nav menu
const closeNav= () => {
    navItems.style.display = 'none';
    openNavBtn.style.display = 'inline-block';
    closeNavBtn.style.display = 'none'; 

}
openNavBtn.addEventListener('click', openNav);
closeNavBtn.addEventListener('click', closeNav);