<div x-data="{nomenclatures:@entangle('nomenclatures')}"
     x-init="$watch('nomenclatures', value => {
        Alpine.store('nomenclatures', {
           values: value,
           getName(id) {
               return nomenclatures.find(item => item.id === id)?.name
           }
        })
     })"
></div>
