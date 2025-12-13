<div class="bg-white rounded-lg shadow p-6">
    <form wire:submit="save" class="space-y-6">
        <div class="bg-gray-100 p-4 rounded-lg mb-6">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-600">Número da Ordem</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $ordem->numero_ordem }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Cliente</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $ordem->cliente->nome }}</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-900 mb-2">Aparelho *</label>
                <input type="text" wire:model="aparelho" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                @error('aparelho') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-900 mb-2">Status *</label>
                <select wire:model="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    @foreach(\App\Models\OrdemServico::STATUS as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
                @error('status') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-900 mb-2">Defeito Relatado *</label>
                <textarea wire:model="defeito_relatado" rows="4"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"></textarea>
                @error('defeito_relatado') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-900 mb-2">Orçamento</label>
                <div class="relative">
                    <span class="absolute left-3 top-2.5 text-gray-500">R$</span>
                    <input type="number" wire:model="orcamento" step="0.01"
                        class="w-full pl-8 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
                @error('orcamento') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-900 mb-2">Valor Aprovado</label>
                <div class="relative">
                    <span class="absolute left-3 top-2.5 text-gray-500">R$</span>
                    <input type="number" wire:model="valor_aprovado" step="0.01"
                        class="w-full pl-8 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
                @error('valor_aprovado') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-900 mb-2">Técnico</label>
                <select wire:model="tecnico_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">Não atribuído</option>
                    @foreach($tecnicos as $tecnico)
                        <option value="{{ $tecnico->id }}">{{ $tecnico->name }}</option>
                    @endforeach
                </select>
                @error('tecnico_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-900 mb-2">Observações</label>
                <textarea wire:model="observacoes" rows="3"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"></textarea>
                @error('observacoes') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="flex gap-4">
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
                Salvar Alterações
            </button>
            <a href="{{ route('ordensservico.show', $ordem) }}" class="px-6 py-2 bg-gray-300 text-gray-900 rounded-lg hover:bg-gray-400 font-medium">
                Cancelar
            </a>
        </div>
    </form>
</div>
