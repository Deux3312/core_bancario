$(function () {

  $('textarea.mentionprepop').mentionsInput({
    triggerChar: ['#', '@'],
    defaultTriggerChar: '@',
    useCurrentVal: true,
    onDataRequest:function (mode, query, callback,triggerChar) {
      var data = [
        { id:1, name:'Kenneth Auchenberg', 'avatar':'http://cdn0.4dots.com/i/customavatars/avatar7112_1.gif', 'type':'contact' },
        { id:2, name:'Jon Froda', 'avatar':'http://cdn0.4dots.com/i/customavatars/avatar7112_1.gif', 'type':'contact' },
        { id:3, name:'Anders Pollas', 'avatar':'http://cdn0.4dots.com/i/customavatars/avatar7112_1.gif', 'type':'contact' },
        { id:4, name:'Kasper Hulthin', 'avatar':'http://cdn0.4dots.com/i/customavatars/avatar7112_1.gif', 'type':'contact' },
        { id:5, name:'Andreas Haugstrup', 'avatar':'http://cdn0.4dots.com/i/customavatars/avatar7112_1.gif', 'type':'contact' },
        { id:6, name:'Pete Lacey', 'avatar':'http://cdn0.4dots.com/i/customavatars/avatar7112_1.gif', 'type':'contact' },
        { id:7, name:'kenneth@auchenberg.dk', 'avatar':'http://cdn0.4dots.com/i/customavatars/avatar7112_1.gif', 'type':'contact' },
        { id:8, name:'Pete Awesome Lacey', 'avatar':'http://cdn0.4dots.com/i/customavatars/avatar7112_1.gif', 'type':'contact' },
        { id:9, name:'Kenneth Hulthin', 'avatar':'http://cdn0.4dots.com/i/customavatars/avatar7112_1.gif', 'type':'contact' },
        { id:"apple", name:'apple', 'avatar':'http://cdn0.4dots.com/i/customavatars/avatar7112_1.gif', 'type':'tag', 'trigger': '#' },
        { id:"banana", name:'banana', 'avatar':'http://cdn0.4dots.com/i/customavatars/avatar7112_1.gif', 'type':'tag', 'trigger': '#' },
        { id:"cherry", name:'cherry', 'avatar':'http://cdn0.4dots.com/i/customavatars/avatar7112_1.gif', 'type':'tag', 'trigger': '#' },
        { id:"durian", name:'durian', 'avatar':'http://cdn0.4dots.com/i/customavatars/avatar7112_1.gif', 'type':'tag', 'trigger': '#' }
      ];

      data = _.filter(data, function(item) { return item.name.toLowerCase().indexOf(query.toLowerCase()) > -1  && (triggerChar == item.trigger || (!item.trigger && triggerChar == '@'))});

      callback.call(this, data);
    }
  });

  $('.get-syntax-text-prepop').click(function() {
    $('textarea.mentionprepop').mentionsInput('val', function(text) {
      alert(text);
    });
  });

  $('.get-mentions-prepop').click(function() {
    $('textarea.mentionprepop').mentionsInput('getMentions', function(data) {
      alert(JSON.stringify(data));
    });
  }) ;

});
