const searchInput = document.getElementById('search-input');
const searchBox = document.querySelector('.search');

searchInput.addEventListener('focus', () => {
    searchBox.style.border = '2px solid #4db8ff'
    searchBox.style.boxShadow = '0 0 5px #4db8ff';
});
searchInput.addEventListener('blur', () => {
    searchBox.style.border = '2px solid #4db8ff';
    searchBox.style.boxShadow = 'none';
});

