<?php
/**
 * Test script: validates _has_book_quotes behavior for books.
 *
 * Run from WordPress root:
 *   wp eval 'require "wp-content/themes/hypatia/test-has-book-quotes.php";'
 *
 * Compares:
 *   - Truth: have_rows('book_quotes', $id) when ACF is available
 *   - Cached: get_post_meta($id, '_has_book_quotes', true)
 *
 * Reports: total books, how many have meta set, mismatches, and sample IDs.
 */

if ( ! function_exists( 'get_posts' ) ) {
	echo "Error: Not in WordPress context. Run with: wp eval 'require \"wp-content/themes/hypatia/test-has-book-quotes.php\";'\n";
	return;
}

$books = get_posts( array(
	'post_type'      => 'books',
	'post_status'    => 'publish',
	'posts_per_page' => -1,
	'orderby'        => 'date',
	'order'          => 'DESC',
) );

$total = count( $books );
$meta_set = 0;
$meta_missing = 0;
$matches = 0;
$mismatches = 0;
$mismatch_samples = array();
$acf_available = function_exists( 'have_rows' );

foreach ( $books as $book ) {
	$id = $book->ID;
	$cached = get_post_meta( $id, '_has_book_quotes', true );

	if ( $cached === '' || $cached === false ) {
		$meta_missing++;
	} else {
		$meta_set++;
	}

	if ( ! $acf_available ) {
		continue;
	}

	$truth = have_rows( 'book_quotes', $id );
	$cached_bool = ( $cached === '1' );

	if ( $cached_bool === $truth ) {
		$matches++;
	} else {
		$mismatches++;
		if ( count( $mismatch_samples ) < 5 ) {
			$mismatch_samples[] = array(
				'id'     => $id,
				'title'  => get_the_title( $id ),
				'cached' => $cached,
				'truth'  => $truth ? 'has highlights' : 'no highlights',
			);
		}
	}
}

echo "\n=== _has_book_quotes validation ===\n\n";
echo "Total books:        " . $total . "\n";
echo "Meta set (1 or 0):  " . $meta_set . "\n";
echo "Meta missing:       " . $meta_missing . "\n";

if ( $acf_available ) {
	echo "\n(Comparing cached value to have_rows('book_quotes') truth)\n";
	echo "Matches:           " . $matches . "\n";
	echo "Mismatches:        " . $mismatches . "\n";
	if ( ! empty( $mismatch_samples ) ) {
		echo "\nSample mismatches:\n";
		foreach ( $mismatch_samples as $s ) {
			echo "  ID {$s['id']} \"{$s['title']}\": cached={$s['cached']}, truth={$s['truth']}\n";
		}
	}
} else {
	echo "\nACF have_rows() not available; skipping match/mismatch check.\n";
}

echo "\n";
if ( $meta_missing > 0 && $acf_available ) {
	echo "Run backfill to set _has_book_quotes for all books:\n";
	echo "  wp eval 'hypatia_backfill_has_book_quotes();'\n\n";
}
if ( $mismatches === 0 && $meta_set === $total && $total > 0 ) {
	echo "OK: All books have _has_book_quotes set and it matches have_rows().\n\n";
}
