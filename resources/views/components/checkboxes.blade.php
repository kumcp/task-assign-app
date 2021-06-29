<div id="tree"></div>
<script type="text/javascript">
    const data = [
        {text: 'Chức vụ', children: [ 
            { text: 'Chức vụ 1', children: [ {text: 'Cá nhân 1'}, {text: 'Cá nhân 2'} ] },
            { text: 'Chức vụ 2'},
            { text: 'Chức vụ 3', children: [ {text: 'Cá nhân 3'} ] }, 
        ]},
        {text: 'Phòng/ban', children: [ { text: 'IT' } ] },
        
    ];
    $(document).ready(function () {
        var tree = $('#tree').tree({
            uiLibrary: 'bootstrap4',
            dataSource: data,
            checkboxes: true,
            autoload: true,
        });
        
    });
</script>