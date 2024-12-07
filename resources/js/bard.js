Statamic.booting(() => {

    Statamic.$bard.buttons(() => {
      return [
        {
          name: 'insertHyhpens',
          text: 'Insert Soft Hyphens',
          command: (editor) => editor.commands.insertContent('↵'),
          html: `↵`,
        },
      ];
    });
  
  });
  