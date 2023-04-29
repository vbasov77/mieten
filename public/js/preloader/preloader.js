const bod1 = document.querySelector('main');
const markup = `<div class="preloader" >
            <img src="../../images/loader/Dual.gif" >
        </div>`;
bod1.style.display = 'none';
bod1.insertAdjacentHTML('beforebegin', markup);
document.addEventListener("DOMContentLoaded", () => {
    document.querySelector('.preloader').remove();
    setTimeout(() => {
        bod1.style.display = 'block'
    }, 500);
});