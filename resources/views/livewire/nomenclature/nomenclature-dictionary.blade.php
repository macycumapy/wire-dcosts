<div x-data="{
        nomenclatures:@entangle('nomenclatures'),
        store(nomenclatures) {
            Alpine.store('nomenclatures', {
               values: nomenclatures,
               getName(id) {
                   return nomenclatures.find(item => item.id === id)?.name
               }
            })
        }
    }"
     x-init="store(nomenclatures); $watch('nomenclatures', value => store(value))"
></div>
