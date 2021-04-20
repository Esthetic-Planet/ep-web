/**
 * Multiple choice
 * Made with \2764
 */


let datalist = {
    cosmeticsurgery: [{
        label: "Lifting del viso",
        value: "Lifting_du_visage",
      },
      {
        label: "Blefaroplastica",
        value: "Blepharoplastie",
      },
      {
        label: "Rinoplastica",
        value: "Rhinoplastie",
      },
      {
        label: "Rinoplastica etnica",
        value: "Rhinoplastie_Ethnique",
      },
      {
        label: "Genioplastica",
        value: "Genioplastie",
      },
      {
        label: "Lifting del seno",
        value: "Lifting_des_seins",
      },
      {
        label: "Riduzione del seno",
        value: "Reduction_mammaire",
      },
      {
        label: "Aumento del seno",
        value: "Augmentation_mammaire",
      },
      {
        label: "Aumento de le labbra",
        value: "Augmentation_des_levres",
      },
      {
        label: "Ginecomastia",
        value: "Gynecomastie",
      },
      {
        label: "Addominoplastica",
        value: "Abdominoplastie",
      },
      {
        label: "Liposuzione",
        value: "Liposuccion",
      },
      {
        label: "Lipofillig dei glutei",
        value: "Lipofilling_des_fesses_BBL",
      },
      {
        label: "Lifting del braccio",
        value: "Lifting_bras",
      },
      {
        label: "Lifting della coscia",
        value: "Lifting_cuisses",
      },
      {
        label: "Otoplastica",
        value: "Otoplastie",
      },
      {
        label: "Aumento del pene",
        value: "Augmentation_penienne",
      },
      {
        label: "Altro",
        value: "Autre",
      },
    ],
  
    Anneau_Sleeve_Bypass: [{
        label: "Sleeve",
        value: "Sleeve",
      },
      {
        label: "Bypass",
        value: "Bypass",
      },
      {
        label: "Palloncino gastrico",
        value: "Ballon_gastrique",
      },
      {
        label: "Botox gastrico",
        value: "Botox_gastrique",
      },
      {
        label: "Bendaggio gastrico",
        value: "Anneau_gastrique",
      },
      {
        label: "Altro",
        value: "Autre",
      },
    ],
  
    hairtransplant: [{
        label: "FUE",
        value: "FUE",
      },
      {
        label: "FUT",
        value: "FUT",
      },
      {
        label: "DHI",
        value: "DHI",
      },
      {
        label: "BHT",
        value: "BHT",
      },
      {
        label: "Trapianto di barba",
        value: "Greffe_Barbe",
      },
      {
        label: "Altro",
        value: "Autre",
      },
    ],
    dentalcare: [{
        label: "Faccette dentali",
        value: "Facettes_Dentaires",
      },
      {
        label: "Impianti dentali",
        value: "Implants_Dentaires",
      },
      {
        label: "Ponti dentali",
        value: "Couronnes_Dentaires",
      },
      {
        label: "Ricostruzione totale",
        value: "Reconstruction_totale",
      },
      {
        label: "Altro",
        value: "Autre",
      },
    ],
    vision: [{
        label: "Lasik",
        value: "Lasik",
      },
      {
        label: "Implant multifocal",
        value: "Implant_multifocal",
      },
      {
        label: "Altro",
        value: "Autre",
      },
    ],
      
      PMA: [{
      label: "FIP Fecondazione in Provetta",
      value: "FIV_ICSI",
    },
    {
      label: "Donazione di ovociti",
      value: "FIV_Don_ovocyte",
    },
    {
      label: "Donazione di sperma",
      value: "FIV_Don_sperme",
    },
    {
      label: "Altro",
      value: "Autre",
    },
  ],
  
    destinations: [{
        label: "Turchia",
        value: "Turquie",
      },
      {
        label: "Ungheria",
        value: "Hongrie",
      },
      {
        label: "Belgic",
        value: "belgique",
      },
      {
        label: "Tailandia",
        value: "thailande",
      },
          {
        label: "Spagna",
        value: "espagne",
      },
             {
        label: "Georgia",
        value: "georgie",
      },
          {
        label: "Tailandia",
        value: "thailande",
      },
      {
        label: "India",
        value: "Inde",
      },
      {
        label: "Portogallo",
        value: "Portugal",
      },
      {
        label: "Tunisia",
        value: "tunisie",
      },
      {
        label: "Repubblica Ceca",
        value: "republique_tcheque",
      },
    ],
  
  }
  
  
  var medicalSpecialties = [];
  var operation = [];
  
  var multiSpecialties = new SelectPure(".multi-select", {
    options: [{
        label: "Trapianto di capelli",
        value: "hairtransplant",
      },
      {
        label: "Chirurgie plastic",
        value: "cosmeticsurgery",
      },
      {
        label: "Cure dentale",
        value: "dentalcare",
      },
      {
        label: "Perdit di peso",
        value: "Anneau_Sleeve_Bypass",
      },
      {
        label: "Vista",
        value: "vision",
      },
      {
        label: "Riproduzione Assistita",
        value: "PMA",
      },
    ],
    multiple: false,
    icon: "fa fa-times",
    placeholder: "- Scegli una specialità -",
    onChange: value => {
  
      medicalSpecialty = value;
  
      document.getElementById('medical_speciality_c').value = value;
      // medicalSpecialties = [value]; when multiple values
  
      if (value.length > 0) {
        document.getElementsByClassName('multi-select-2')[0].style.display = 'block';
  
        if (document.getElementsByClassName('multi-select-2')[0].getElementsByClassName('select-pure__select__red')[0]) {
          document.getElementsByClassName('multi-select-2')[0].getElementsByClassName('select-pure__select__red')[0].remove();
        }
  
        let multiOperation = new SelectPure(".multi-select-2", {
          options: datalist[medicalSpecialty],
  
          multiple: true,
          autocomplete: true,
          required: true,
          icon: "fa fa-times",
          placeholder: "- Scegli una o più transazioni -",
          onChange: values => {
  
            let element = document.getElementById('chir_esthe_ope1_c');
            for (var i = 0; i < element.options.length; i++) {
              element.options[i].selected = values.indexOf(element.options[i].value) >= 0;
            }
  
          },
          classNames: {
            select: "select-pure__select__red",
            dropdownShown: "select-pure__select--opened",
            multiselect: "select-pure__select--multiple",
            label: "select-pure__label",
            placeholder: "select-pure__placeholder",
            dropdown: "select-pure__options",
            option: "select-pure__option",
            autocompleteInput: "select-pure__autocomplete",
            selectedLabel: "select-pure__selected-label",
            selectedOption: "select-pure__option--selected",
            placeholderHidden: "select-pure__placeholder--hidden",
            optionHidden: "select-pure__option--hidden",
          }
        });
      } else {}
    },
    classNames: {
      select: "select-pure__select",
      dropdownShown: "select-pure__select--opened",
      multiselect: "select-pure__select--multiple",
      label: "select-pure__label",
      placeholder: "select-pure__placeholder",
      dropdown: "select-pure__options",
      option: "select-pure__option",
      autocompleteInput: "select-pure__autocomplete",
      selectedLabel: "select-pure__selected-label",
      selectedOption: "select-pure__option--selected",
      placeholderHidden: "select-pure__placeholder--hidden",
      optionHidden: "select-pure__option--hidden",
    }
  });
  
  var multiDestinations = new SelectPure(".multi-select-destination", {
    options: datalist.destinations,
  
    multiple: true,
    autocomplete: true,
    icon: "fa fa-times",
    placeholder: "- Scegli una o più destinazioni -",
    onChange: values => {
  
      let element = document.getElementById('destinations_c');
      for (var i = 0; i < element.options.length; i++) {
        element.options[i].selected = values.indexOf(element.options[i].value) >= 0;
      }
  
    },
    classNames: {
      select: "select-pure__select",
      dropdownShown: "select-pure__select--opened",
      multiselect: "select-pure__select--multiple",
      label: "select-pure__label",
      placeholder: "select-pure__placeholder",
      dropdown: "select-pure__options",
      option: "select-pure__option",
      autocompleteInput: "select-pure__autocomplete",
      selectedLabel: "select-pure__selected-label",
      selectedOption: "select-pure__option--selected",
      placeholderHidden: "select-pure__placeholder--hidden",
      optionHidden: "select-pure__option--hidden",
    }
  });