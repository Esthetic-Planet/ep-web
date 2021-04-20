/**
 * Multiple choice
 * Made with \2764
 */


let datalist = {
  cosmeticsurgery: [{
      label: "Lifting du visage",
      value: "Lifting_du_visage",
    },
    {
      label: "Blepharoplastie",
      value: "Blepharoplastie",
    },
    {
      label: "Rhinoplastie",
      value: "Rhinoplastie",
    },
    {
      label: "Rhinoplastie ethnique",
      value: "Rhinoplastie_Ethnique",
    },
    {
      label: "Genioplastie",
      value: "Genioplastie",
    },
    {
      label: "Lifting des seins",
      value: "Lifting_des_seins",
    },
    {
      label: "Réduction mammaire",
      value: "Reduction_mammaire",
    },
    {
      label: "Augmentation mammaire",
      value: "Augmentation_mammaire",
    },
    {
      label: "Augmentation des lèvres",
      value: "Augmentation_des_levres",
    },
    {
      label: "Gynecomastie",
      value: "Gynecomastie",
    },
    {
      label: "Abdominoplastie",
      value: "Abdominoplastie",
    },
    {
      label: "Liposuccion",
      value: "Liposuccion",
    },
    {
      label: "Lipofilling des fesses BBL",
      value: "Lipofilling_des_fesses_BBL",
    },
    {
      label: "Lifting bras",
      value: "Lifting_bras",
    },
    {
      label: "Lifting cuisses",
      value: "Lifting_cuisses",
    },
    {
      label: "Otoplastie",
      value: "Otoplastie",
    },
    {
      label: "Augmentation pénienne",
      value: "Augmentation_penienne",
    },
    {
      label: "Autre",
      value: "Autre",
    },
  ],

  Chirurgie_bariatrique: [{
      label: "Sleeve",
      value: "Sleeve",
    },
    {
      label: "Bypass",
      value: "Bypass",
    },
    {
      label: "Ballon gastrique",
      value: "Ballon_gastrique",
    },
    {
      label: "Botox gastrique",
      value: "Botox_gastrique",
    },
    {
      label: "Anneau gastrique",
      value: "Anneau_gastrique",
    },
    {
      label: "Autre",
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
      label: "Greffe barbe",
      value: "Greffe_Barbe",
    },
    {
      label: "Autre",
      value: "Autre",
    },
  ],
  dentalcare: [{
      label: "Facettes dentaires",
      value: "Facettes_Dentaires",
    },
    {
      label: "Implants dentaires",
      value: "Implants_Dentaires",
    },
    {
      label: "Couronnes Dentaires",
      value: "Couronnes_Dentaires",
    },
    {
      label: "Reconstruction totale",
      value: "Reconstruction_totale",
    },
    {
      label: "Autre",
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
      label: "Autre",
      value: "Autre",
    },
  ],
  PMA: [{
    label: "FIV-ICSI",
    value: "FIV_ICSI",
  },
  {
    label: "FIV don d'ovocyte",
    value: "FIV_Don_ovocyte",
  },
  {
    label: "Vitrification d'ovocytes",
    value: "vitrification_ovocytes",
  },
  {
    label: "Insemination artificielle",
    value: "Insemination_artificielle",
  },
  {
    label: "FIV don de sperme",
    value: "FIV_Don_sperme",
  },
  {
    label: "Autre",
    value: "Autre",
  },
],

  destinations: [{
      label: "Turquie",
      value: "Turquie",
    },
    {
      label: "Hongrie",
      value: "Hongrie",
    },
    {
      label: "Belgique",
      value: "belgique",
    },
    {
      label: "Thaïlande",
      value: "thailande",
    },
    {
      label: "Espagne",
      value: "espagne",
    },
    {
      label: "Géorgie",
      value: "georgie",
    },
    {
      label: "Inde",
      value: "Inde",
    },
    {
      label: "Portugal",
      value: "Portugal",
    },
    {
      label: "Tunisie",
      value: "tunisie",
    },
    {
      label: "République Tchèque",
      value: "republique_tcheque",
    },
  ],

}


var medicalSpecialties = [];
var operation = [];

var multiSpecialties = new SelectPure(".multi-select", {
  options: [{
      label: "Greffe capillaire",
      value: "hairtransplant",
    },
    {
      label: "Chirurgie esthétique",
      value: "cosmeticsurgery",
    },
    {
      label: "Soins dentaires",
      value: "dentalcare",
    },
    {
      label: "Perte de poids",
      value: "Chirurgie_bariatrique",
    },
    {
      label: "Vision",
      value: "vision",
    },
    {
      label: "PMA-FIV",
      value: "PMA",
    },
  ],
  multiple: false,
  icon: "fa fa-times",
  placeholder: "- Choisissez une spécialité -",
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
        placeholder: "- Choisissez une ou plusieurs opérations-",
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
  placeholder: "-Choisissez une ou plusieurs destinations-",
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
