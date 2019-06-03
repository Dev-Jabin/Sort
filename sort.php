<?php

/**
 * @Author: Jabin
 * @Date:   2019-04-27
 * @Email:  jpyan2906@gmail.com
 */

class Sort
{
	public function swap(&$arr,$index1,$index2)
	{
		$temp = $arr[$index2];
		$arr[$index2] = $arr[$index1];
		$arr[$index1] = $temp;
	}

	/**
	 * 冒泡排序
	 * 1.比较相邻元素，如果第一个比第二个大，交换它们
	 * 2.对每一对相邻元素作同样的工作，从开始第一对到结尾的最后一对，这样在最后的元素应该会是最大的数
	 * 3.针对所有的元素重复以上的步骤，除了最后一个
	 * 4.重复步骤1~3，直到排序完成
	 */
	public function bubbleSort($arr,$size)
	{
		for ($i=0; $i < $size-1; $i++) { // 外循环代表排序趟数 size个数字 需要进行 size-1 趟进行排序
			for ($j=0; $j < $size-$i-1; $j++) { // 内循环代表每趟排序对比的次数 第i趟需要对比size-i次
				if ($arr[$j] > $arr[$j+1]) {
					$this->swap($arr,$j,$j+1);
				}
			}
		}
		return $arr;
	}

	/**
	 * 选择排序
	 * 首先在未排序序列中找到最小值，存放在起始位置，然后再从剩余未排列元素寻找最小元素，然后放到已排序序列的末尾。以此类推，直到所有元素均排序完毕。
	 * 1.起始无序区为R[1...n],有序序列为空
	 * 2.第i趟排序(i=1,2,3...n-1)开始时，当前有序区和无序区为R[1....i-1]和R[i.....n)。该趟在无序序列中找到最小的元素R[k]，将它与无序区的第1个记录交换，使R[1...i]和R[i+1...n)个数分别增加一个和减少一个元素。
	 * 3.n-1趟结束，排序完成
	 */
	public function selectSort($arr,$size)
	{
		for ($i=0; $i < $size-1; $i++) { 
			$min = $i; //最小元素的索引值
			for ($j=$i+1; $j < $size; $j++) { 
				if ($arr[$min]> $arr[$j]) {
					$min = $j;
				}
			}
			$this->swap($arr,$min,$i);
		}
		return $arr;
	}

	/**
	 * 插入排序
	 * 通过构建有序序列，选择未排序第一个数据，在已排序序列中从后向前扫描，找到相应位置插入
	 * 1.从第一个元素开始，该元素可以认为已经被排序
	 * 2.取出下一个元素，在已经排序的元素序列中从后向前扫描
	 * 3.如果该元素（已排序）大于新元素，将该元素移到下一位置
	 * 4.重复步骤3，直到找到已排序的元素小于或者等于新元素的位置
	 * 5.将新元素插入到该位置后
	 * 6.重复步骤2~5
	 */
	public function insertSort($arr,$size)
	{
		for ($i=1; $i < $size; $i++) { 
			$j = $i;
			while ($j>0 && $arr[$j] < $arr[$j-1]) {
				$this->swap($arr,$j,$j-1);
				$j--;
			}
		}
		return $arr;
	}

	/**
	 * https://www.cnblogs.com/heyuquan/p/insert-sort.html
	 * 二分查找插入排序
	 * 二分查找插入是直接插入的一个变种，区别在于，在有序序列中查找新元素插入位置时，为了减少元素比较次数提高效率，采用二分查找算法查找插入的位置。
	 * 1.将原序列分成有序区和无序区。a[0…i-1]为有序区，a[i…n] 为无序区。（i从1开始）
	 * 2.从无序区中取出第一个元素，即a[i]，使用二分查找算法在有序区中查找要插入的位置索引j
	 * 3.将a[j]到a[i-1]的元素后移，并将a[i]赋值给a[j]
	 * 4.重复步骤2~3，直到无序区元素为0
	 */
	public function binaryInsertSort($arr,$size)
	{
		for ($i=1; $i < $size; $i++) { 
			$leftIndex = 0;
			$rightIndex = $i-1;
			$temp = $arr[$i];
			// 二分查找，使用while获取需要插入值的最终索引
			while ($leftIndex <= $rightIndex) {
				$mid = intval(($leftIndex + $rightIndex)/2);
				if ($arr[$mid] > $arr[$i]) {
					$rightIndex = $mid-1;
				}else{
					$leftIndex = $mid+1;
				}
			}
			// 将这个索引右边的元素 全部像右移动一位
			for ($j=$i-1; $j >= $leftIndex; $j--) { 
				$arr[$j+1] = $arr[$j];
			}
			$arr[$leftIndex] = $temp;
		}
		return $arr;
	}

	/**
	 * 归并排序
	 * https://www.cnblogs.com/chengxiao/p/6194356.html
	 * @param  [type] $arr  [description]
	 * @param  [type] $size [description]
	 * @param  [type] $flag [description]
	 * @return [type]       [description]
	 */
	public function mergeSort($arr,$size)
	{
		if ($size<2) {
			return $arr;
		}
		$mid = intval($size/2);
		$leftArr = array_slice($arr, 0,$mid);
		$rightArr = array_slice($arr, $mid);
		$leftArr = $this->mergeSort($leftArr, count($leftArr));
		$rightArr = $this->mergeSort($rightArr, count($rightArr));
		$arr = $this->mergeSortMerge($leftArr, $rightArr);
		return $arr;
	}

	private function mergeSortMerge($leftArr, $rightArr)
	{
		$tempArr = array();
		while (count($leftArr) && count($rightArr)) {
			$tempArr[] = $leftArr[0] < $rightArr[0] ? array_shift($leftArr) : array_shift($rightArr);
		}
		$midArr = array_merge($tempArr,$leftArr,$rightArr);
		return $midArr;
	}

	/**
	 * 快速排序
	 * 通过一趟排序，将待排记录分隔成独立的两部分，其中一部分元素均比另外一部分元素小，然后对两部分分别进行排序，最终达到整个序列有序，使用递归思想
	 * 1.从序列中选择一个元素作为基准（简单起见，选第一个元素即可）
	 * 2.从当前序列的末尾开始向前查找，当找到小于基准值时停止，值记为RV
	 * 3.从当前序列的基准值下一个元素开始向后查找，当找到大于基准时停止，值记录为LV
	 * 4.交换RV和LV
	 * 5.继续重复2～3直至两边相遇停止，当前停止位置便是基准值应该在位置，将基准值放到该位置
	 * 6.此时左序列的值均小于基准值，右序列的值均大于基准值。分别递归左序列和右序列
	 * 7.全部完成时即可得到完整的有序序列
	 */
	public function quickSort(&$arr,$leftIndex,$rightIndex)
	{
		if ($leftIndex > $rightIndex) {
			return;
		}
		$i = $leftIndex;
		$j = $rightIndex;
		$target = $arr[$leftIndex];
		while ($i != $j) {
			while ($arr[$j] >= $target  && $i<$j) {
				$j--;
			}
			while ($arr[$i] <= $target  && $i<$j) {
				$i++;
			}
			$this->swap($arr,$i,$j);
		}
		$arr[$leftIndex] = $arr[$i];
		$arr[$i] = $target;
		$this->quickSort($arr,$leftIndex,$i-1);
		$this->quickSort($arr,$i+1,$rightIndex);
		return $arr;
	}

	/**
	 * 希尔排序
	 * 希尔排序是插入排序的一种又称为“最小增量排序”，是直接插入排序的一种优化改进版本
	 * 1. 对于n个待排序的数列，取一个小于n的整数gap(gap被称为步长，通常开始选为n/2)
	 * 2. 根据所选步长，将待排序元素分成若干组子序列，所有距离为gap的倍数的记录放在同一个组中
	 * 3. 对各组内的元素进行直接插入排序
	 * 4. 继续改变gap=gap/2，重复第3步，直到gap=1时，整个数列就是有序的
	 *
	 * https://www.cnblogs.com/skywang12345/p/3597597.html#a3
	 * https://www.cnblogs.com/chengxiao/p/6104371.html
	 */
	public function shellSort($arr,$size)
	{
		for ($gap=intval($size/2); $gap > 0; $gap=intval($gap/2)) {
			for ($i=$gap; $i < $size; $i++) { 
				$j = $i;
				while ($j - $gap>=0 && $arr[$j] < $arr[$j-$gap]) {
					$this->swap($arr,$j,$j-$gap);
					$j = $j - $gap;
				}
			}
		}
		return $arr;
	}
}

$testArr = [1,3,5,7,9,2,4,6,8,10,1,2,3,4];
$size = count($testArr);

$sort = new Sort();
$resArrBubble = $sort->bubbleSort($testArr,$size);
$resArrSelect = $sort->selectSort($testArr,$size);
$resArrInsert = $sort->insertSort($testArr,$size);
$resArrBinaInsert = $sort->binaryInsertSort($testArr,$size);
$resArrMerge = $sort->mergeSort($testArr,$size);
$resArrQuick = $sort->quickSort($testArr,0,$size-1);
$resArrShell = $sort->shellSort($testArr,$size);
echo "=======================\nBubble Sort\n=======================\n";
foreach ($resArrBubble as $value) {
	echo "$value ";
}
echo "\n\n\n=======================\nSelect Sort\n=======================\n";
foreach ($resArrSelect as $value) {
	echo "$value ";
}
echo "\n\n\n=======================\nInsert Sort\n=======================\n";
foreach ($resArrInsert as $value) {
	echo "$value ";
}
echo "\n\n\n=======================\nBinary Insert Sort\n=======================\n";
foreach ($resArrBinaInsert as $value) {
	echo "$value ";
}
echo "\n\n\n=======================\nMerge Sort\n=======================\n";
foreach ($resArrMerge as $value) {
	echo "$value ";
}
echo "\n\n\n=======================\nQuick Sort\n=======================\n";
foreach ($resArrQuick as $value) {
	echo "$value ";
}
echo "\n\n\n=======================\nShell Sort\n=======================\n";
foreach ($resArrShell as $value) {
	echo "$value ";
}

echo "\n";