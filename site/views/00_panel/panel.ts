(() => {
	const hmrScript = `${location.origin}:5173/@vite/client`;
	const head = document.getElementsByTagName("head")[0];
	const script = document.createElement("script");

	script.src = hmrScript;
	script.setAttribute("type", "module");

	head.appendChild(script);

	console.log("panel");
})();
