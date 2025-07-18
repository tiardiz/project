print_tree() {
  local dir="$1"
  local prefix="$2"
  local items=("$dir"/*)
  local count=${#items[@]}
  local i=0

  for item in "${items[@]}"; do
    i=$((i + 1))
    local name=$(basename "$item")
    local connector="├──"
    [ "$i" -eq "$count" ] && connector="└──"

    echo "${prefix}${connector} ${name}"

    if [ -d "$item" ]; then
      local new_prefix="${prefix}│   "
      [ "$i" -eq "$count" ] && new_prefix="${prefix}    "
      print_tree "$item" "$new_prefix"
    fi
  done
}

echo "."
print_tree "." ""
