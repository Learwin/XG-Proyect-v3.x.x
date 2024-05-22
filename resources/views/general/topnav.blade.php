<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>

<div id="header_top">
    <table class="header" style="margin:0 auto">
        <tr class="header">
            <td class="header" style="width:5;">
                <table class="header">
                    <tr class="header">
                        <td class="header">
                            <img src="{{ $dpath }}planets/small/s_{{ $image }}.jpg" height="50" width="50">
                        </td>
                        <td class="header">
                            <table class="header">
                                <select size="1" onchange="location = this.options[this.selectedIndex].value;">
                                {!! $planetlist !!}
                                </select>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
            <td class="header">
                <table class="header" id="resources" cellspacing="0" cellpadding="0" padding-right="30">
                    <tr class="header" style="text-align:center">
                        <td width="85" class="header">
                            <img src="{{ $dpath }}resources/metal.gif" width="42" height="22">
                        </td>
                        <td width="85" class="header">
                            <img src="{{ $dpath }}resources/crystal.gif" width="42" height="22">
                        </td>
                        <td width="85" class="header">
                            <img src="{{ $dpath }}resources/deuterium.gif" width="42" height="22">
                        </td>
                        <td width="85" class="header">
                            <img src="{{ $dpath }}resources/energy.gif" width="42" height="22">
                        </td>
                    </tr>
                    <tr class="header" style="text-align:center">
                        <td class="header" width="85">
                            <span style="font-weight:700;font-style: italic;">{{ $metal }}</span>
                        </td>
                        <td class="header" width="85">
                            <span style="font-weight:700;font-style: italic;">{{ $crystal }}</span>
                        </td>
                        <td class="header" width="85">
                            <span style="font-weight:700;font-style: italic;">{{ $deuterium }}</span>
                        </td>
                        <td class="header" width="85">
                            <span style="font-weight:700;font-style: italic;">{{ $energy }}</span>
                        </td>
                    </tr>
                    <tr class="header" style="text-align:center">
                        <td class="header" width="90">{!! $re_metal !!}</td>
                        <td class="header" width="90">{!! $re_crystal !!}</td>
                        <td class="header" width="90">{!! $re_deuterium !!}</td>
                        <td class="header" width="90">{!! $re_energy !!}</td>
                    </tr>
					<tr class="header" style="text-align:center">
                        <td class="header" width="90">{!! $re_metal_hour !!}</td>
                        <td class="header" width="90">{!! $re_crystal_hour !!}</td>
                        <td class="header" width="90">{!! $re_deuterium_hour !!}</td>
                    </tr>
					<tr class="header" style="text-align:center">
                        <td class="header" width="90">{!! $re_max_metal !!}</td>
                        <td class="header" width="90">{!! $re_max_crystal !!}</td>
                        <td class="header" width="90">{!! $re_max_deuterium !!}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    {!! $show_umod_notice !!}
</div>
