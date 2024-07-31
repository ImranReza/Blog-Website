const navItems = document.querySelector('.nav-items');
const openNavBtn = document.querySelector('.open-nav-btn');
const closeNavBtn = document.querySelector('.close-nav-btn');

//opens nav dropdown
const openNav = () =>{
    navItems.style.display = 'flex';
    openNavBtn.style.display='none';
    closeNavBtn.style.display = 'inline-block';

}

const closeNav = () =>{
    navItems.style.display = 'none';
    openNavBtn.style.display='inline-block';
    closeNavBtn.style.display = 'none';

}

//clase nav dropdown

openNavBtn.addEventListener('click',openNav);
closeNavBtn.addEventListener('click',closeNav);





// sidebar handle

const sidebar = document.querySelector('aside');
const showSidebarBtn = document.querySelector('#show-sidebar-btn');
const hideSidebarBtn = document.querySelector('#hide-sidebar-btn');

//shows sidebar on small devices
const showSidebar = () =>{
    sidebar.style.left = '0';
    showSidebarBtn.style.display = 'none';
    hideSidebarBtn.style.display = 'inline-block';
}

//hide sidebar on small devices
const hidesidebar = () =>{
    sidebar.style.left = '-100%';
    showSidebarBtn.style.display = 'inline-block';
    hideSidebarBtn.style.display = 'none';
}

showSidebarBtn.addEventListener('click',showSidebar);
hideSidebarBtn.addEventListener('click',hidesidebar);






