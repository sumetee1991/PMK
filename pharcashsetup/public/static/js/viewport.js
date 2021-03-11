let vh = window.innerHeight * 0.01;
document.documentElement.style.setProperty('--vh', `${vh}px`);

function handleChange(input) {
	if (input.value.length > 13) input.value = input.value.substring(0, 13);
}