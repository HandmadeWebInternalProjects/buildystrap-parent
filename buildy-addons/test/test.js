const addTextInput = (resolve, reject, options) => {

  alert('test')

  options.addField({
    type: "text-fieldtype",
    handle: "another value",
    config: { input_type: 'password' },
    value: "test",
  });

  options.addField({
    type: "text-fieldtype",
    handle: "company_phone",
    config: { input_type: 'phone' },
    value: "44224242",
  });

  resolve();
};

window.Buildy.$hooks.add("text-fieldtype-init", addTextInput);