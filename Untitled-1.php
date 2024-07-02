  // public function store(Request $request)
  // {
  // $request->validate([
  // 'description' => 'required|string|max:255',
  // 'latitude' => 'required|numeric',
  // 'longitude' => 'required|numeric',
  // ]);

  // $point = [
  // 'longitude' => $request->longitude,
  // 'latitude' => $request->latitude,
  // ];

  // $polygon = [
  // ['longitude' => -7.926618, 'latitude' => 12.637981],
  // ['longitude' => -7.839178, 'latitude' => 12.640096],
  // ['longitude' => -7.91555, 'latitude' => 12.576553],
  // ['longitude' => -7.926618, 'latitude' => 12.637981],
  // ['longitude' => -7.9515553, 'latitude' => 12.6654158],
  // ];

  // if (!$this->isInsidePolygon($point, $polygon)) {
  // return response()->json(['error' => 'The location is outside all polygons'], 422);
  // }

  // $announcement = Announcement::create([
  // 'user_id' => auth()->id(),
  // 'description' => $request->description,
  // 'latitude' => $request->latitude,
  // 'longitude' => $request->longitude,
  // ]);

  // return response()->json(['success' => 'Annonce créée avec succès.']);
  // }

  // private function isInsidePolygon($point, $polygon)
  // {
  // if (!is_array($polygon)) {
  // throw new InvalidArgumentException('Polygon must be an array of points');
  // }

  // $x = $point['longitude'];
  // $y = $point['latitude'];

  // $inside = false;
  // for ($i = 0, $j = count($polygon) - 1; $i < count($polygon); $j=$i++) { // $xi=$polygon[$i]['longitude']; // $yi=$polygon[$i]['latitude']; // $xj=$polygon[$j]['longitude']; // $yj=$polygon[$j]['latitude']; // $intersect=(($yi> $y) != ($yj > $y)) && ($x < ($xj - $xi) * ($y - $yi) / ($yj - $yi) + $xi); // if ($intersect) { // $inside=!$inside; // } // } // return $inside; // } // public function checkLocation(Request $request) // { // $point=[ // 'longitude'=> $request->input('longitude'),
          // 'latitude' => $request->input('latitude'),
          // ];

          // $polygons = CoverageZone::all();

          // foreach ($polygons as $polygon) {
          // if ($this->isInsidePolygon($point, $polygon->coordinates)) {
          // return response()->json(['message' => 'The location is inside a polygon']);
          // }
          // }

          // return response()->json(['message' => 'The location is outside all polygons']);
          // }
