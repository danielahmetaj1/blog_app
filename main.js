const navItems = document.querySelector('.nav__items');
const openNavBtn = document.querySelector('#open_nav-btn');
const closeNavBtn = document.querySelector('#close_nav-btn');
//hapja e nav menu
const openNav= () => {
    navItems.style.display = 'flex';
    openNavBtn.style.display = 'none';
    closeNavBtn.style.display = 'block'; 

}

//mbyllja e nav menu
const closeNav= () => {
    navItems.style.display = 'none';
    openNavBtn.style.display = 'block';
    closeNavBtn.style.display = 'none'; 

}
openNavBtn.addEventListener('click', openNav);
closeNavBtn.addEventListener('click', closeNav);




const sidebar = document.querySelector('aside');
const showSidebarBtn = document.querySelector('#show__sidebar-btn');
const hideSidebarBtn = document.querySelector('#hide__sidebar-btn');
//hapja e sidebar

const showSideBar = () => { 
    sidebar.style.left = '0';
    showSidebarBtn.style.display = 'none';
    hideSidebarBtn.style.display = 'inline-block';
}
showSidebarBtn.addEventListener('click',showSideBar );
