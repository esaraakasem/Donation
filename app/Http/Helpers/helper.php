<?php 


function null_string($item)
{
    return blank($item) ? '' : $item;
}

function uploadImg($request, $img_name)
{
    $path = \Storage::disk('public')->putFile('uploads', $request->file($img_name));
    return $path;
}

function uploadImage($img)
{
	return \Storage::disk('public')->putFile('uploads', $img);
}

function deleteImg($img_name)
{
    \Storage::disk('public')->delete('uploads', $img_name);
    return True;
}

function getImgPath($img)
{
	if (is_null($img)) {
		return '';
	}
	return url('/') . '/storage/' . $img;
}

function getSetting($key)
{
	return \App\Models\Setting::where('setting_key',$key)->value('setting_value');
}

function searchFor($query, $col,$word)
{
	$query->where($col, 'LIKE', '%'.$word.'%');
	return $query;
}

function period($time)
{
	$data = [
		'one_time' => 'مرة واحدة',
		'three_months' => 'كل 3 أشهر',
		'one_month' => 'كل شهر',
		'one_week' => 'كل اسبوع',
		'three_minutes' => 'كل 3 دقائق'
	];

	return $data[$time];
}
