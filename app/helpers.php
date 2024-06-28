use App\Models\Classeur;

if (!function_exists('getFullPath')) {
    function getFullPath($classeur) {
        $path = $classeur->libellec;
        while ($classeur->parent != null) {
            $classeur = Classeur::find($classeur->parent);
            if ($classeur) {
                $path = $classeur->libellec . '/' . $path;
            }
        }
        return $path;
    }
}