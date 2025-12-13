<div class="bg-white rounded-lg shadow p-6">
    <form wire:submit="save" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-900 mb-2">Cliente *</label>
                <select wire:model="cliente_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">Selecione um cliente</option>
                    @foreach($clientes as $cliente)
                        <option value="{{ $cliente->id }}">{{ $cliente->nome }}</option>
                    @endforeach
                </select>
                @error('cliente_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-900 mb-2">Aparelho *</label>
                <input type="text" wire:model="aparelho" placeholder="Ex: Notebook, Desktop..." 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                @error('aparelho') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-900 mb-2">Defeito Relatado *</label>
                <textarea wire:model="defeito_relatado" rows="4" placeholder="Descreva o defeito relatado pelo cliente..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"></textarea>
                @error('defeito_relatado') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-900 mb-2">Orçamento</label>
                <div class="relative">
                    <span class="absolute left-3 top-2.5 text-gray-500">R$</span>
                    <input type="number" wire:model="orcamento" step="0.01" placeholder="0.00"
                        class="w-full pl-8 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
                @error('orcamento') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-900 mb-2">Valor Aprovado</label>
                <div class="relative">
                    <span class="absolute left-3 top-2.5 text-gray-500">R$</span>
                    <input type="number" wire:model="valor_aprovado" step="0.01" placeholder="0.00"
                        class="w-full pl-8 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
                @error('valor_aprovado') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-900 mb-2">Observações</label>
                <textarea wire:model="observacoes" rows="3" placeholder="Observações adicionais..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"></textarea>
                @error('observacoes') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="flex gap-4">
            <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-medium">
                Criar Ordem de Serviço
            </button>
            <a href="{{ route('ordensservico.index') }}" class="px-6 py-2 bg-gray-300 text-gray-900 rounded-lg hover:bg-gray-400 font-medium">
                Cancelar
            </a>
        </div>
    </form>
</div>
