@if (!$assentos || $assentos->isEmpty() || !$quantidade_fileiras || !$quantidade_assentos_por_fileira)
<div class="w-full">
        <p class="text-sm text-gray-500 text-center">
                Não há itens para exibir no momento.
        </p>
</div>
@else
<div class="flex flex-col-reverse gap-2 mb-15 items-center">
        @for ($indiceFileira = 0; $indiceFileira < $quantidade_fileiras; $indiceFileira++)
                @php
                $fileiraLetra=chr(65 + $indiceFileira);
                @endphp

                <div class="flex gap-2 items-center">
                <p class="text-muted-foreground text-xs font-semibold mr-5">
                        {{ $fileiraLetra }}
                </p>

                {{-- Loop pelos assentos da fileira --}}
                @for ($indiceAssento = 1; $indiceAssento <= $quantidade_assentos_por_fileira; $indiceAssento++)
                        @php
                        $esteAssento=$assentos->first(function ($x) use ($indiceAssento, $fileiraLetra) {
                        return $x->coluna === $indiceAssento && $x->fileira === $fileiraLetra;
                        });
                        @endphp

                        @if (!$esteAssento)
                        <div class="w-[25px] h-[25px] rounded-sm flex justify-center items-center shrink-0"></div>
                        @continue
                        @endif

                        @if($ehMapaUso && $sessoesAssentos->contains('assento_id', $esteAssento->id))
                        <div style="width: 25px; height: 25px; border-radius: 4px; display: flex; justify-content: center; align-items: center; flex-shrink: 0; background-color: #D4D4D4; font-size: 12px; font-weight: bold; opacity: 0.25">X</div>
                        @elseif ($esteAssento->tipo_assento_id === 1)
                        <div style="width: 25px; height: 25px; border-radius: 4px; display: flex; justify-content: center; align-items: center; flex-shrink: 0; background-color: #D4D4D4;"></div>
                        @elseif ($esteAssento->tipo_assento_id === 2)
                        <div style="width: 25px; height: 25px; border-radius: 12px; font-size: 12px; display: flex; justify-content: center; align-items: center; flex-shrink: 0; background-color: #D4D4D4;"><x-mdi-wheelchair style="width: 20px; height: 20px" /></div>
                        @elseif ($esteAssento->tipo_assento_id === 3)
                        <div style="width: 25px; height: 25px; font-weight: bold; font-size: 12px; border-radius: 12px; display: flex; justify-content: center; align-items: center; flex-shrink: 0; background-color: #D4D4D4;">A</div>
                        @elseif ($esteAssento->tipo_assento_id === 4)
                        <div style="width: 25px; height: 25px; font-weight: bold; font-size: 12px; border-bottom-left-radius: 12px; border-top-left-radius: 12px; display: flex; justify-content: center; align-items: center; flex-shrink: 0; background-color: #D4D4D4;">NE</div>
                        @elseif ($esteAssento->tipo_assento_id === 5)
                        <div style="width: 25px; height: 25px; font-weight: bold; font-size: 12px; border-bottom-right-radius: 12px; border-top-right-radius: 12px; display: flex; justify-content: center; align-items: center; flex-shrink: 0; background-color: #D4D4D4;">ND</div>
                        @endif
                        @endfor

</div>
@endfor




</div>

<div style="margin-top: 20px; padding: 16px; background-color: #f5f5f5; border-radius: 8px;">
        <h3 style="font-weight: bold; margin-bottom: 12px; font-size: 16px;">Legenda</h3>

        <div style="display: flex; flex-direction: column; gap: 10px;">

                @if($ehMapaUso)
                <div style="display: flex; align-items: center; gap: 10px;">
                <div style="width: 25px; height: 25px; border-radius: 4px; display: flex; justify-content: center; align-items: center; flex-shrink: 0; background-color: #D4D4D4; font-size: 12px; font-weight: bold; opacity: 0.25">X</div>
                <span style="font-size: 14px;">Ocupado</span>
                </div>
                @endif

                <div style="display: flex; align-items: center; gap: 10px;">
                        <div style="width: 25px; height: 25px; border-radius: 4px; background-color: #D4D4D4;"></div>
                        <span style="font-size: 14px;">Normal</span>
                </div>

                <div style="display: flex; align-items: center; gap: 10px;">
                        <div style="width: 25px; height: 25px; border-radius: 12px; font-size: 12px; display: flex; justify-content: center; align-items: center; flex-shrink: 0; background-color: #D4D4D4;"><x-mdi-wheelchair style="width: 20px; height: 20px" /></div>
                        <span style="font-size: 14px;">Deficiente físico (espaço destinado para posicionar cadeira de rodas)</span>
                </div>

                <div style="display: flex; align-items: center; gap: 10px;">
                        <div style="width: 25px; height: 25px; font-weight: bold; font-size: 12px; border-radius: 12px; display: flex; justify-content: center; align-items: center; flex-shrink: 0; background-color: #D4D4D4;">A</div>
                        <span style="font-size: 14px;">Acompanhante (reservado para acompanhantes dos assentos
                                especiais)</span>
                </div>

                <div style="display: flex; align-items: center; gap: 10px;">
                        <div style="width: 25px; height: 25px; font-weight: bold; font-size: 12px; border-bottom-left-radius: 12px; border-top-left-radius: 12px; display: flex; justify-content: center; align-items: center; flex-shrink: 0; background-color: #D4D4D4;">NE</div>
                        <span style="font-size: 14px;">Namoradeira (esquerda)</span>
                </div>

                <div style="display: flex; align-items: center; gap: 10px;">
                        <div style="width: 25px; height: 25px; font-weight: bold; font-size: 12px; border-bottom-right-radius: 12px; border-top-right-radius: 12px; display: flex; justify-content: center; align-items: center; flex-shrink: 0; background-color: #D4D4D4;">ND</div>
                        <span style="font-size: 14px;">Namoradeira (direita)</span>
                </div>
        </div>
</div>
@endif