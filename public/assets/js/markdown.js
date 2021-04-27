document.addEventListener('DOMContentLoaded', () => {
    var content = document.querySelector('#tutorial_content')
    var preview = document.querySelector('.markDownPreview')
    var converter = new showdown.Converter()

    var defaultOptions = showdown.getDefaultOptions();

    Object.entries(defaultOptions).forEach(item => {
        if(item[1] == false) {        
            converter.setOption(item[0], 'true');
        }
    })

    content.addEventListener('keyup', (event) => {
        let text = content.value
        let html = converter.makeHtml(text);
        preview.innerHTML = html
    })
})