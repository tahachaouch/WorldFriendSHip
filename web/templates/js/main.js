var tags = new Bloodhound({
    prefetch: '/tags.json',
    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('libelle'),
    queryTokenizer: Bloodhound.tokenizers.whitespace,
})

$('.tag-input').tagsinput({
    typeaheadjs: [{
        highlights: true
    }, {
        name : 'tags',
        display: 'libelle',
        value: 'libelle',
        source: tags
    }]
})